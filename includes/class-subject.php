<?php
class smgt_subject
{
    public function smgt_get_teacher_own_subject($teacher_id)
	{
		global $wpdb;
		$table_smgt_beds=$wpdb->prefix.'teacher_subject';
		$result=$wpdb->get_results("SELECT subject_id From $table_smgt_beds WHERE teacher_id=$teacher_id OR created_by=".$teacher_id);
		return $result;
	}
}
?>