<?php

namespace caritor\cms\controllers;

use Yii;
use caritor\cms\models\CmsMenu;
use caritor\cms\models\CmsMenuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use caritor\cms\models\CmsMenuArea;
use caritor\cms\models\CmsPages;
use yii\helpers\BaseJson;
use yii\filters\AccessControl;

/**
 * MenuController implements the CRUD actions for CmsMenu model.
 */
class MenuController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['selectarea', 'managemenu'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['selectarea','managemenu'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all CmsMenu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CmsMenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CmsMenu model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CmsMenu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CmsMenu();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->menu_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CmsMenu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->menu_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CmsMenu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
     * Will act as step 1 in managing menu item's.
     * Let's to choose the desired menu area to begin with.
     * @return CmsMenu the loaded model
     */

    public function actionSelectarea()
    {
        $model = new CmsMenu();
        return $this->render('arealist', [
            'model' => $model
        ]);
    }

    /**
     * Finds the area_id and disaply's menu's been added under it.
     * If area_id is not posted in request, the browser will be redireced to 'select area' page
     * @param integer $area_id
     */

    public function actionManagemenu()
    {
        $form_data = Yii::$app->request->post('CmsMenu');
        
        $area_id = $form_data['area_id'];

        // redirect request to select area if area_id is not set in request
        if($area_id) {

            $parent_menus = $this->getParentMenus($area_id);
            $menu = array();
            if(count($parent_menus) > 0 ){
                foreach ($parent_menus as $parent_menu) {
                    $menu_model = $this->findModel($parent_menu['menu_id']);
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

            return $this->render('manage_menus', [
                    'model' => $menu,
                    'area_id' => $area_id,
                    'cms_pages' => $this->getAllCmsPages($area_id)
                ]);
        } else {
            return $this->redirect(['selectarea']);
        }
    }

    /**
     * Get all active cms pages
     * @return CmsPages the retrieved model
    */
    public function getAllCmsPages(){
        return CmsPages::find()->select(['page_id','menu_title'])->where(['status' => '1'])->asArray()->all();        
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
                    $cmenu[] = array(
                        'menu_id' => $child_menu['menu_id'],
                        'menu_title' => $menu_model->page->menu_title,
                        'menu_status' => $menu_model->page->status,
                        'parent_menu_id' => $child_menu['parent_menu_id'],
                        'page_id' => $child_menu['page_id'],
                        'sort_order' => $child_menu['sort_order'],
                        'children' => $this->getChildMenus($child_menu['area_id'], $child_menu['menu_id'])
                    );
                }
            }
            return $cmenu;
        }
    }

    public function actionIns(){
        CmsMenu::deleteAll('area_id = 2');
    }


    public function actionSavemenu(){

        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $area_id = $data['area_id'];
            $menu_items = BaseJson::decode($data['menu_json']);

            if(count($menu_items) > 0) {

                // Delete Existing Menu's Before Adding New
                CmsMenu::deleteAll('area_id = '.$area_id);

                // Insert New Set Of Menu's
                $p = $c = $sc = 1;
                foreach($menu_items as $parent){
                    $model = new CmsMenu();
                    $model->page_id = $parent['pageid'];
                    $model->sort_order = $p;
                    $model->area_id = $area_id;
                    $model->created_by = Yii::$app->user->id;
                    $model->save();
                    $new_parent_id = $model->menu_id;
                    
                    //Children 
                    if($new_parent_id > 0 && isset($parent['children'])) {
                        foreach ($parent['children'] as $children) {
                            $model = new CmsMenu;
                            $model->page_id = $children['pageid'];
                            $model->sort_order = $c;
                            $model->area_id = $area_id;
                            $model->parent_menu_id = $new_parent_id;
                            $model->created_by = Yii::$app->user->id;
                            $model->save();
                            $new_child_id = $model->menu_id;

                            // Sub Child
                            if($new_child_id > 0 && isset($children['children'])) {
                                foreach ($children['children'] as $sub_children) {
                                    $model = new CmsMenu;
                                    $model->page_id = $sub_children['pageid'];
                                    $model->sort_order = $sc;
                                    $model->area_id = $area_id;
                                    $model->parent_menu_id = $new_child_id;
                                    $model->created_by = Yii::$app->user->id;
                                    $model->save();
                                    $sc++;
                                }
                            }
                            $c++;
                        }
                    }
                    $p++;
                }
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'status' => 'success',
                    'message' => '<strong>Success !! </strong>Menu Item/s Succesfully Added / Updated',
                ];
            } else {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'status' => 'failed',
                    'message' => '<strong>Failed !! </strong> Menu Item is empty. Kindly add atleast one menu to a area',
                ];
            }
        } else {
            $this->redirect(['selectarea']);
        }
    }
}
