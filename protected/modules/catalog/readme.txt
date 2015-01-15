************Описание модуля "Каталог" (catalog)*************************

Пользовательская часть (frontend)
---------------------------------

Представления:
/views/frontend/default/index.php - вывод главной страницы каталога
/views/frontend/default/view.php - просмотр категории каталога
/views/frontend/default/_view.php - представление одной категории в списке
/views/frontend/default/_productview.php - представление одного товара в списке
/views/frontend/default/product.php - карточка товара
/views/frontend/default/_complectations.php - вывод вариантов комплектации с возможностью подсчета финальной цены

Виджеты:
/components/CatalogCatToMainWidget.php - вывод корневых категорий на главную страницу
(использует представление /components/views/cattomain.php)

/components/MenuCategoryTreeWidget.php - вывод категорий каталога в виде раскрывающегося меню
(использует представление /components/views/menucategorytreewidget.php)
Использование: в шаблон поместить php-вставку <?$this->widget('application.modules.catalog.components.MenuCategoryTreeWidget');?>