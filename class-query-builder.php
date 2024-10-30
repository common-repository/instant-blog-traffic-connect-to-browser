<?php
/*

	ActionPHP Builder (c) 2012 Action PHP Ltd
	Rapid Development Framework


*/

	class wp2crx_action_php_builder{
		
		protected $table_name;
		
		public function wp2crx_action_php_builder($table_name){
			
			global $wpdb;
			$prefix = $wpdb->prefix;
			
			$this->table_name = $prefix.$table_name;
		}
		
		public function __construct($table_name){
			
			$this->wp2crx_action_php_builder($table_name);
		
		}
		
		public function table(){
			
			return $this->_create_the_table();
			
		}
		
		protected function _create_item($value, $field, $type){
			
			$this->validate('0', $field, $type);
			
			global $wpdb;
			$table_name = $this->table_name;
						
			$wpdb->insert(
			
				$table_name,
				
				array(
				
					$field => $wpdb->escape($value)
				
				),
				
				array(
				
					$type
				
				)
				
				);
				
			$insert_id = $wpdb->insert_id;
				
			return $insert_id;
			
		}
		
		public function create($value, $field='name', $type='%s'){
			
			return $this->_create_item($value, $field, $type);			
			
		}
		
		protected function _get_item($id){
			
			global $wpdb;
			
			$table_name = $this->table_name;
			
			if( $id == 'all' ){
				
				$results = $wpdb->get_results("SELECT * FROM $table_name WHERE Status='fresh'  ORDER BY id DESC;");
				
			} else {
				
				$results = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$id' AND Status='fresh' LIMIT 1;");
				$results = $results[0];
				
			}
		
			return $results;	
		}
		
		public function get( $id='all' ){
			
			return $this->_get_item($id);
			
		}
			
		
		protected function _get_items_by_field( $id , $field ){
			//$this->validate( $id, $field );
			
			global $wpdb;
			$table_name = $this->table_name;
						

			$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE $field = '$id' AND Status='fresh' ;" );

			return $results;		

		}

		public function get_by($id, $field){

			return $this->_get_items_by_field($id, $field);

		}
		
		protected function _update_item($id, $value, $field, $type){
			
			global $wpdb;
			$table_name = $this->table_name;
			
			$this->validate($id, $field, $type);
			$id = (int)$id;
			
			$wpdb->update(
			
				$table_name,
				
				array(
				
					$field => $wpdb->escape($value)
									
				),
				
				array(
				
					'id' => $wpdb->escape($id)
				
				),
				
				array(
				
					$type
				),
				
				array(
				
					'%d'
				
				)
			
			);

			
		}
		
		public function update($id, $field, $value,  $type ='%s'){
			
			return $this->_update_item($id, $value, $field, $type);
			
		}
		
		
		protected function _delete_item( $id ){
		
			global $wpdb;
			$table_name = $this->table_name;
			
			$this->validate( $id, $field );
			
			$wpdb->update(
			
				$table_name,
				
				array(
				
					'Status' => $wpdb->escape('deleted')
									
				),
				
				array(
				
					'id' => $wpdb->escape( $id )
				
				),
				
				array(
				
					'%s'
				),
				
				array(
				
					'%d'
				
				)
			
			);
					
		}
		
		public function delete( $id ){
			
			return $this->_delete_item( $id );
			
		}
		
		
		protected function _validate_parameters( $id, $field, $type ){
			
			$types = array ( '%s', '%d', '%f' );
			
			if(!empty($type)){
				
				if(!in_array($type, $types)){
					
					die('Invalid escape type.');
					
				}
			
			}
			
			if(!empty($field)){
			
				if(!preg_match('/^[A-Za-z0-9_]+$/', $field)){
					
					die('Invalid DB field.');
					
				}
			
			}
			
			$id = (string) $id;
			
			if(!empty($id)){
					
				if(!ctype_digit($id)){
				
					die('Invalid DB ID.');
					
				}
			
			}
			
		}
		
		public function validate( $id, $field='', $type='%s' ){
			
			return $this->_validate_parameters($id, $field, $type);
		}
	}

?>