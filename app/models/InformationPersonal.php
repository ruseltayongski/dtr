

<?php
	class InformationPersonal extends Eloquent {
	    protected $connection = 'pis';
		protected $table = 'personal_information';
	    protected $primaryKey = 'id';

        public function transferred(){
            return $this->hasMany(TransferCdo::class, 'userid', 'userid');
        }
	}

?>