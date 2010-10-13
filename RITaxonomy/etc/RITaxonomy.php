<?php
/**
 * @todo: write tests and add description per method
 *
 */
class RITaxonomy{
	protected $db;
	
	function init(){
		global $db;
		$this->db = $db; 	
	}
	
	function insertTaxonomy($term_id, $taxonomy, $parent = 0, $description='', $count = 0){
		$sql = "INSERT INTO ".TABLE_RI_TERM_TAXONOMY." (term_id, taxonomy, description, parent, count) VALUES(:term_id, :taxonomy, :parent, :description, :count)";
		$sql = $this->db->bindVars($sql, ':term_id', $term_id, 'integer');
		$sql = $this->db->bindVars($sql, ':taxonomy', $taxonomy, 'string');
		$sql = $this->db->bindVars($sql, ':parent', $parent, 'integer');
		$sql = $this->db->bindVars($sql, ':description', $description, 'string');
		$sql = $this->db->bindVars($sql, ':count', $count, 'integer');
		$this->db->Execute($sql);
		return $this->db->insert_ID();
	}
	
	function findTaxonomy($term_id, $taxonomy){
		$sql = "SELECT term_taxonomy_id FROM ".TABLE_RI_TERM_TAXONOMY." WHERE term_id = :term_id AND taxonomy = :taxonomy";
		$sql = $this->db->bindVars($sql, ':taxonomy', $taxonomy, 'string');
		$sql = $this->db->bindVars($sql, ':term_id', $term_id, 'integer');
		$check = $this->db->Execute($sql);
		if($check->RecordCount() == 0) return false;
		return $check->fields['term_taxonomy_id'];
	}
	
	function insertRelationship($object_id, $term_taxonomy_id, $term_order = 0){
		global $db;
		$sql = "INSERT INTO ".TABLE_RI_TERM_TAXONOMY_RELATIONSHIPS." (object_id , term_taxonomy_id , term_order) VALUES(:object_id, :term_taxonomy_id, :term_order)";
		$sql = $this->db->bindVars($sql, ':object_id', $object_id, 'integer');
		$sql = $this->db->bindVars($sql, ':term_taxonomy_id', $term_taxonomy_id, 'integer');
		$sql = $this->db->bindVars($sql, ':term_order', $term_order, 'integer');
		$this->db->Execute($sql);
		return $this->db->insert_ID();
	}
	
	function findRelationship($object_id, $term_taxonomy_id){
		$sql = "SELECT id FROM ".TABLE_RI_TERM_TAXONOMY_RELATIONSHIPS." WHERE term_taxonomy_id = :term_taxonomy_id AND object_id = :object_id";
		$sql = $this->db->bindVars($sql, ':object_id', $object_id, 'integer');
		$sql = $this->db->bindVars($sql, ':term_taxonomy_id', $term_taxonomy_id, 'integer');
		$check = $this->db->Execute($sql);
		if($check->RecordCount() == 0) return false;
		return $check->fields['id'];
	}
}