<?php

class SSortableBehavior extends CActiveRecordBehavior {
	
	public $sortField = 'sort_order';
	public $categoryField;
	public $titleField = 'title';
	public $condition = null;
	public $inverse = false;

	public function beforeSave($event) {
		
		$owner = $this->getOwner();
		if(!$owner->getIsNewRecord()) return;
		//Если запись новая, устанавливается минимальное значение порядка. Остальные записи сдвигаются на 1
		$db=$owner->getDbConnection();
		/*$owner->{$this->sortField} = 1;
		$owner->updateAll(array($this->sortField => new CDbExpression($db->quoteColumnName($this->sortField).'+1')), array(
            'condition'=>'`outarea_id`=:outarea_id',
            'params'=>array(
                ':outarea_id'=>$_GET['outarea']
				)
			));*/
        // Находим максимальное значение поля сортировки
		$models=$owner->findAll();
		foreach($models as $model) {
			$sort_orders[]=$model->{$this->sortField};
		}
        if(!empty($sort_orders)){
            arsort($sort_orders);
            $max_order=current($sort_orders);
        } else{$max_order=0;}

        // Устанавливаем значение поля сортировки - максимальное+10
        $owner->{$this->sortField} = $max_order+10;
	}
	
	//Перемещение записи вверх или вниз в списке
	public function move($direction){
		$owner=$this->getOwner();
		
		if($direction=='up'){
			if($owner->_is_first()) 
				throw new CHttpException(400,$owner->{$this->titleField} . ' Уже первый');
			
			$criteria=new CDbCriteria;
			$criteria->condition="{$this->sortField}" . ($this->inverse ? '>' : '<') . "{$owner->{$this->sortField}}";
			$criteria->order = "{$this->sortField} " . ($this->inverse ? 'asc' : 'desc');
		}
		elseif($direction=='down'){
			if($owner->_is_last()) 
				throw new CHttpException(400,$owner->{$this->titleField} . 'Уже последний');
			
			$criteria=new CDbCriteria;
			$criteria->condition="{$this->sortField}" . ($this->inverse ? '<' : '>') . "{$owner->{$this->sortField}}";
			$criteria->order = "{$this->sortField} " . ($this->inverse ? 'desc' : 'asc');
		}
		else
			throw new CHttpException(400, 'Invalid request');
		
		if($this->categoryField){
			$db = $owner->getDbConnection();
			$alias=$db->quoteColumnName($owner->getTableAlias());
			$criteria->addCondition($alias.'.'.$db->quoteColumnName($this->categoryField).'='.$owner->{$this->categoryField});
		}
		if ($this->condition)
			$criteria->addCondition($this->condition);
			
		$closest = $owner->find($criteria);
		$this->_swap($closest,$owner);
	}
	
	//Меняет местами 2 записи
	private function _swap($first, $second){
		$firstValue = $first->{$this->sortField};
		
		$first->{$this->sortField} = $second->{$this->sortField};
		$second->{$this->sortField} = $firstValue;
		
		$first->save();
		$second->save();
    }
	
	
	public function _is_first(){
        return($this->getOwner()->id == $this->_get_first()->id);
    }
    
    public function _is_last(){
        return($this->getOwner()->id == $this->_get_last()->id);
    }
    
    private function _get_first(){
		$owner = $this->getOwner();
		
		$db = $owner->getDbConnection();
		
		$criteria=new CDbCriteria;
		$criteria->order = "{$this->sortField} " . ($this->inverse ? 'desc' : 'asc');
		$criteria->limit = 1;
		
		$alias=$db->quoteColumnName($owner->getTableAlias());
		
		if($this->categoryField)
			$criteria->addCondition($alias.'.'.$db->quoteColumnName($this->categoryField).'='.$owner->{$this->categoryField});
			
		if ($this->condition)
			$criteria->addCondition($this->condition);
		
		return $owner->find($criteria);
    }
    
    private  function _get_last(){
		$owner = $this->getOwner();
		
		$db = $owner->getDbConnection();
		
		$criteria=new CDbCriteria;
		$criteria->order = "{$this->sortField} " . ($this->inverse ? 'asc' : 'desc');
		$criteria->limit = 1;
		
		$alias=$db->quoteColumnName($owner->getTableAlias());
		
		if($this->categoryField)
			$criteria->addCondition($alias.'.'.$db->quoteColumnName($this->categoryField).'='.$owner->{$this->categoryField});
			
		if ($this->condition)
			$criteria->addCondition($this->condition);
		
		return $owner->find($criteria);
    }


	
}
