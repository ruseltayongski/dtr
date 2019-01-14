@extends('layouts.leave_credits_layout')

@section('content')
    <h3>Employee Leave Credits</h3>
    <div id="credits_table" data-get="{{ asset('get/regular/employee') }}"></div>
@endsection
@section('js')
    @parent
    <script>
        var container1 = document.getElementById('credits_table');
        var hot1;
        hot1 = new Handsontable(container1, {
            startRows: 8,
            startCols: 4,
            rowHeaders: true,
            colWidths : [100,400,150,150],
            stretchH: 'all',
            colHeaders: true,
            fillHandle: {
                autoInsertRow: false,
            },
            colHeaders: ['UserID','Employee Name', 'Vacation Leave','Sick Leave'],
            cells: function(r,c, prop) {
                var cellProperties = {};
                if (c=== 0 || c === 1) cellProperties.readOnly = true;
                return cellProperties;
            }
        });
        $("#save").click(function(){
            document.body.style.cursor = 'wait';
            var tabledata = hot1.getData();
            for(var i = 0; i < tabledata.length; i++)
            {
                try { tabledata[i][3] = tabledata[i][3].toString().replace(/,/g, ''); } catch(err) { tabledata[i][3] = null;  }
                try { tabledata[i][5] = tabledata[i][5].toString().replace(/,/g, ''); } catch(err) { tabledata[i][5] = null;  }
                try { tabledata[i][7] = tabledata[i][7].toString().replace(/,/g, ''); } catch(err) { tabledata[i][7] = null;  }
                try { tabledata[i][9] = tabledata[i][9].toString().replace(/,/g, ''); } catch(err) { tabledata[i][9] = null;  }

                try { tabledata[i][4] = tabledata[i][4].toString().replace(/,/g, ''); } catch(err) { tabledata[i][4] = null;  }
                try { tabledata[i][6] = tabledata[i][6].toString().replace(/,/g, ''); } catch(err) { tabledata[i][6] = null;  }
                try { tabledata[i][8] = tabledata[i][8].toString().replace(/,/g, ''); } catch(err) { tabledata[i][8] = null;  }
                try { tabledata[i][10] = tabledata[i][10].toString().replace(/,/g, ''); } catch(err) { tabledata[i][10] = null; }
            }
            
            var url = $("#container1").data('save');
            var postdata = {
                data: JSON.stringify(tabledata)
            };
            
            $.post(url, postdata, function (res) {
                hot1.loadData(JSON.parse(res));
                document.body.style.cursor = 'default';
            });
        });
        var url = $("#credits_table").data('get');
        $.get(url,function(resdata){
            hot1.loadData(JSON.parse(resdata));
        });
        
    </script>
@endsection



