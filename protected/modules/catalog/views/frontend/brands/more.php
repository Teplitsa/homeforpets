<?php
	foreach ($products as $product){
		$this->renderPartial('/default/_productview',array('data'=>$product));
		$count = $categories[$product->idCategory->id]['count'];
		};
	if ($id>0) echo '<a href="'.$brand.'" id="'.$coll.'" name="'.($id).'" class="showhide">Еще товары категории</a>';
?>