                    <?php
                    $this->pageTitle=Yii::app()->name . ' - Error';
                    $this->breadcrumbs=array(
                        'Ошибка',
                    );
                    ?>

					<div class="h1bg">
						<div class="h1pic">
							<h1>Ошибка <?php echo $code; ?></h1>
						</div>
					</div>
                    <?php echo CHtml::encode($message); ?>
