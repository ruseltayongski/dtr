<?php
/**
 * Created by PhpStorm.
 * User: doh7_it
 * Date: 10/3/2023
 * Time: 4:12 PM
 */

class LeaveCardView extends Eloquent
{
    protected $table = 'leave_cardview';
    protected $primaryKey = 'id';

    public function modified()
    {
        return $this->hasMany('ModifiedLeave', 'extended_id', 'extended_id');
    }

    public function extended()
    {
        return $this->belongsTo('ExtendedLeave', 'extended_id');
    }

    public function getFormattedDatesAttribute()
    {
        if (!$this->extended || !$this->extended->start || !$this->extended->end) {
            return html_entity_decode(stripslashes($this->date_used));
        }
    
        // Map date => ['status' => 1|2, 'modified' => $m]
        $dateMeta = array();
    
        foreach ($this->modified as $m) {
            if ($m->status == 1) {
                if (!$m->to_start || !$m->to_end) continue;
    
                $period = new DatePeriod(
                    new DateTime($m->to_start),
                    new DateInterval('P1D'),
                    (new DateTime($m->to_end))->modify('+1 day')
                );
                foreach ($period as $d) {
                    $dateMeta[$d->format('Y-m-d')] = array('status' => 1, 'modified' => $m);
                }
            } elseif ($m->status == 2) {
                if (!$m->from_start || !$m->from_end) continue;
    
                $period = new DatePeriod(
                    new DateTime($m->from_start),
                    new DateInterval('P1D'),
                    (new DateTime($m->from_end))->modify('+1 day')
                );
                foreach ($period as $d) {
                    $dateMeta[$d->format('Y-m-d')] = array('status' => 2, 'modified' => $m);
                }
            }
        }
    
        // Build full flat list of [date, status, modified]
        $period = new DatePeriod(
            new DateTime($this->extended->start),
            new DateInterval('P1D'),
            (new DateTime($this->extended->end))->modify('+1 day')
        );
    
        $days = array();
        foreach ($period as $d) {
            $key  = $d->format('Y-m-d');
            $meta = isset($dateMeta[$key]) ? $dateMeta[$key] : null;
    
            $days[] = array(
                'date'        => $d,
                'status'      => $meta ? $meta['status'] : 0,
                'modified_id' => $meta ? $meta['modified']->id : null,
                'modified'    => $meta ? $meta['modified'] : null,
                'awol'        => false,
            );
        }
    
        // Mark last N *active* (status 0) days as AWOL, walking backward
        $awolRemaining = (int) $this->vl_abswop + (int) $this->sl_abswop;
    
        if ($awolRemaining > 0) {
            for ($i = count($days) - 1; $i >= 0 && $awolRemaining > 0; $i--) {
                if ($days[$i]['status'] == 0) {
                    $days[$i]['awol'] = true;
                    $awolRemaining--;
                }
            }
        }
    
        // Group consecutive days with same status, modified record, and awol flag
        $groups  = array();
        $current = null;
    
        foreach ($days as $day) {
            if ($current === null) {
                $current = array(
                    'start'       => $day['date'],
                    'end'         => $day['date'],
                    'status'      => $day['status'],
                    'modified_id' => $day['modified_id'],
                    'modified'    => $day['modified'],
                    'awol'        => $day['awol'],
                );
                continue;
            }
    
            $isConsecutive = $day['date']->format('Y-m-d') ==
                (clone $current['end'])->modify('+1 day')->format('Y-m-d');
    
            if ($isConsecutive
                && $day['status'] == $current['status']
                && $day['modified_id'] == $current['modified_id']
                && $day['awol'] == $current['awol']
            ) {
                $current['end'] = $day['date'];
            } else {
                $groups[] = $current;
                $current = array(
                    'start'       => $day['date'],
                    'end'         => $day['date'],
                    'status'      => $day['status'],
                    'modified_id' => $day['modified_id'],
                    'modified'    => $day['modified'],
                    'awol'        => $day['awol'],
                );
            }
        }
        if ($current !== null) {
            $groups[] = $current;
        }
    
        // Format each group based on status/awol
        $parts = array();
        foreach ($groups as $g) {
            $label = $this->formatRange($g['start'], $g['end']);
    
            if ($g['status'] == 1) {
                $parts[] = '<s>' . $label . '</s>';
            } elseif ($g['status'] == 2) {
                $toLabel = $this->formatRange(
                    new DateTime($g['modified']->to_start),
                    new DateTime($g['modified']->to_end)
                );
                $parts[] = '<del>' . $label . '</del> (' . $toLabel . ')';
            } elseif ($g['awol']) {
                $parts[] = '<span style="color:red">' . $label . '</span>';
            } else {
                $parts[] = $label;
            }
        }
    
        return implode(', ', $parts);
    }
    private function formatRange($start, $end)
    {
        // Single day
        if ($start->format('Y-m-d') == $end->format('Y-m-d')) {
            return $start->format('M d, Y');
        }

        $sameYear  = $start->format('Y') == $end->format('Y');
        $sameMonth = $sameYear && $start->format('m') == $end->format('m');

        if ($sameMonth) {
            return $start->format('M d') . ' - ' . $end->format('d, Y');
        } elseif ($sameYear) {
            return $start->format('M d') . ' - ' . $end->format('M d, Y');
        } else {
            return $start->format('M d, Y') . ' - ' . $end->format('M d, Y');
        }
    }
}