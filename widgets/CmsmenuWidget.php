<?php

namespace caritor\cms\components;

use yii\base\Widget;
use yii\helpers\Html;
use caritor\cms\models\CmsMenu;
use caritor\cms\models\CmsMenuArea;
use yii\helpers\Json;

Class CmsmenuWidget extends Widget {

	public $area_code;
	public $menu_items;
	
	public function init(){
		parent::init();
		if($this->area_code === null){
			$this->menu_items = null;
		}else{
			$is_area_id_exists = CmsMenuArea::find()->where(['area_code' => $this->area_code])->exists();

			if($is_area_id_exists){
				$area_id = CmsMenuArea::find()->where(['area_code' => $this->area_code])->select('area_id')->one();
				$this->menu_items = $this->getActiveMenus($area_id);
			} else {
				$this->menu_items = 'Invalid Area Code / Area Code Not Exists';
			}			
		}
	}
	
	public function run(){
		return Json::encode($this->menu_items);
	}

	public function getActiveMenus($area_id){
		$menu = null;
		if($area_id != null) {
            $parent_menus = $this->getParentMenus($area_id);
            if(count($parent_menus) > 0 ){
                foreach ($parent_menus as $parent_menu) {
                    $menu_model = $this->findModel($parent_menu['menu_id']);
                    if($menu_model->page->status == 1){
	                    $menu[] = array(
	                        'menu_id' => $parent_menu['menu_id'],
	                        'menu_title' => $menu_model->page->menu_title,
	                        'menu_status' => $menu_model->page->status,
	                        'parent_menu_id' => $parent_menu['parent_menu_id'],
	                        'page_id' => $parent_menu['page_id'],
	                        'sort_order' => $parent_menu['sort_order'],
	                        'children' => $this->getChildMenus($area_id, $parent_menu['menu_id'])
	                    );
	                }
                }
            }
        }
        return $menu;
	}

	/**
     * Finds the CmsMenu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsMenu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsMenu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

	/**
     * Retrieve all parent / first level of menu's under a area
     * @param integer $area_id
     * @return Array $parent_menus
    */
    public function getParentMenus($area_id){
        $parent_menus = CmsMenu::find()->where(['area_id' => $area_id,'parent_menu_id' => NULL])->orderBy('sort_order')->asArray()->all();
        return $parent_menus;
    }

    /**
     * Retrieve all child menu's given area and parent
     * @param integer $area_id, integer $parent_id
     * @return Array $cmenu
    */
    public function getChildMenus($area_id, $parent_id){
        if(empty($parent_id)){
            return null;
        } else {
            $child_menus = CmsMenu::find()->where(['area_id' => $area_id,'parent_menu_id' => $parent_id])->asArray()->all();
            $cmenu = null;
            if(count($child_menus) > 0) {
                foreach ($child_menus as $child_menu) {
                    $menu_model = $this->findModel($child_menu['menu_id']);
                    if($menu_model->page->status == 1){
	                    $cmenu[] = array(
	                        'menu_id' => $child_menu['menu_id'],
	                        'menu_title' => $menu_model->page->menu_title,
	                        'menu_status' => $menu_model->page->status,
	                        'parent_menu_id' => $child_menu['parent_menu_id'],
	                        'page_id' => $child_menu['page_id'],
	                        'sort_order' => $child_menu['sort_order'],
	                        'sub_children' => $this->getChildMenus($child_menu['area_id'], $child_menu['menu_id'])
	                    );
	                }
                }
            }
            return $cmenu;
        }
    }
}