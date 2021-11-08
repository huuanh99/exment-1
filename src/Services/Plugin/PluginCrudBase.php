<?php
namespace Exceedone\Exment\Services\Plugin;

use Encore\Admin\Widgets\Form;
use Encore\Admin\Widgets\Grid\Grid;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Widgets\Form as WidgetForm;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Layout\Content;
use Exceedone\Exment\Services\Plugin\PluginCrud;

/**
 * Plugin CRUD(and List)
 */
abstract class PluginCrudBase extends PluginPublicBase
{
    use PluginBase, PluginPageTrait;
    
    public function __construct($plugin, $options = [])
    {
        $this->plugin = $plugin;
        $this->pluginOptions = new PluginOption\PluginOptionCrud($options);
    }

    protected $endpoint = 'crud';

    /**
     * content title
     *
     * @var string
     */
    protected $title;

    /**
     * content description
     *
     * @var string
     */
    protected $description;

    /**
     * content icon
     *
     * @var string
     */
    protected $icon;

    /**
     * Crud grid class name. If customize, change class name.
     *
     * @var string
     */
    public $gridClass = PluginCrud\CrudGrid::class;

    /**
     * Crud show class name. If customize, change class name.
     *
     * @var string
     */
    public $showClass = PluginCrud\CrudShow::class;

    /**
     * Crud create class name. If customize, change class name.
     *
     * @var string
     */
    public $createClass = PluginCrud\CrudForm::class;

    /**
     * Crud edit class name. If customize, change class name.
     *
     * @var string
     */
    public $editClass = PluginCrud\CrudForm::class;

    /**
     * Crud delete class name. If customize, change class name.
     *
     * @var string
     */
    public $deleteClass = PluginCrud\CrudForm::class;

    /**
     * Get fields definitions
     *
     * @return array|Collection
     */
    public function getFieldDefinitions(){
        return [];
    }

    /**
     * Get data list
     *
     * @return Collection
     */
    public function getList(array $options = []) : Collection{
        return collect();
    }

    /**
     * Get data paginate
     *
     * @return LengthAwarePaginator|null
     */
    public function getPaginate(array $options = []) : ?LengthAwarePaginator
    {
        return null;
    }

    /**
     * read single data
     *
     * @return array|Collection
     */
    public function getData($id, array $options = []){
        return collect();
    }

    /**
     * set form info
     *
     * @return Form|null
     */
    public function setForm(Form $form, bool $isCreate, array $options = []) : ?Form{
        return null;
    }
    
    /**
     * post create value
     *
     * @return mixed
     */
    public function postCreate(array $posts, array $options = []){}

    /**
     * edit posted value
     *
     * @return mixed
     */
    public function putEdit($id, array $posts, array $options = []){}
    
    /**
     * delete value
     * 
     * @param $id string|array target ids. If multiple check, calls as array.
     * @return mixed
     */
    public function delete($id, array $options = []){}

    /**
     * Get the value of endpoint
     */ 
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Set the value of endpoint
     *
     * @return  self
     */ 
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Get class name. Toggle using endpoint name.
     *
     * @param string|null $endpoint
     * @return string|null class name
     */
    public function getPluginClassName(?string $endpoint)
    {
        if($endpoint == $this->endpoint){
            return get_class($this);
        }
        return null;
    }
    
    public function _plugin()
    {
        return $this->plugin;
    }
    
    /**
     * Get route uri for page
     *
     * @return string
     */
    public function getRouteUri($endpoint = null)
    {
        if (!isset($this->plugin)) {
            return null;
        }

        return $this->plugin->getRouteUri($endpoint);
    }

    /**
     * Get full url
     *
     * @return string
     */
    public function getFullUrl(...$endpoint) : string
    {
        array_unshift($endpoint, $this->getEndpoint());
        return $this->plugin->getFullUrl(...$endpoint);
    }

    /**
     * Get primary key
     *
     * @return string
     */
    public function getPrimaryKey() : string
    {
        $definitions = $this->getFieldDefinitions();
        return array_get(collect($definitions)->first(function($definition, $key){
            return array_boolval($definition, 'primary');
        }), 'key');
    }


    /**
     * Whether show data. If false, disable show link.
     * Default: true
     *
     * @return bool
     */
    public function enableShow($value) : bool
    {
        return true;
    }

    /**
     * Whether create data. If false, disable create button.
     * Default: true
     *
     * @return bool
     */
    public function enableCreate(array $options = []) : bool
    {
        return true;
    }

    /**
     * Whether edit target data. If false, disable edit button and link.
     * Default: true
     *
     * @return bool
     */
    public function enableEdit($value, array $options = []) : bool
    {
        return true;
    }

    /**
     * Whether delete target data. If false, disable delete button and link.
     * Default: true
     *
     * @return bool
     */
    public function enableDelete($value, array $options = []) : bool
    {
        return true;
    }
    
    /**
     * Whether export data. If false, disable export button and link.
     * Default: false
     *
     * @return bool
     */
    public function enableExport(array $options = []) : bool
    {
        return false;
    }

    /**
     * Whether freeword search. If true, show search box in grid.
     * Default: false
     *
     * @return bool
     */
    public function enableFreewordSearch(array $options = []) : bool
    {
        return false;
    }


    /**
     * Callback grid. If add event, definition.
     *
     * @param Grid $grid
     * @return void
     */
    public function callbackGrid(Grid $grid)
    {
    }


    /**
     * Callback grid row action. If add event, definition.
     *
     * @param Grid $grid
     * @return void
     */
    public function callbackGridAction($actions)
    {
    }

    /**
     * Callback show. If add event, definition.
     *
     * @param WidgetForm $form
     * @return void
     */
    public function callbackShow(WidgetForm $form, Box $box)
    {
    }

    /**
     * Callback create. If add event, definition.
     *
     * @param WidgetForm $form
     * @return void
     */
    public function callbackCreate(WidgetForm $form, Box $box)
    {
    }

    /**
     * Callback edit. If add event, definition.
     *
     * @param WidgetForm $form
     * @return void
     */
    public function callbackEdit(WidgetForm $form, Box $box)
    {
    }

    /**
     * Set column difinition for grid. If add event, definition.
     *
     * @param Grid $grid
     * @return void
     */
    public function setGridColumnDifinition(Grid $grid, string $key, string $label)
    {
        $grid->column($key, $label);
    }

    /**
     * Set column difinition for show. If add event, definition.
     *
     * @param WidgetForm $form
     * @return void
     */
    public function setShowColumnDifinition(WidgetForm $form, string $key, string $label)
    {
        $form->display($key, $label);
    }

    /**
     * Set column difinition for create. If add event, definition.
     *
     * @param WidgetForm $form
     * @return void
     */
    public function setCreateColumnDifinition(WidgetForm $form, string $key, string $label)
    {
        $form->text($key, $label);
    }

    /**
     * Set column difinition for edit. If add event, definition.
     *
     * @param WidgetForm $form
     * @return void
     */
    public function setEditColumnDifinition(WidgetForm $form, string $key, string $label)
    {
        $form->text($key, $label);
    }

    /**
     * Set column difinition for form's primary key. If add event, definition.
     *
     * @param WidgetForm $form
     * @return void
     */
    public function setFormPrimaryDifinition(WidgetForm $form, string $key, string $label)
    {
        $form->display($key, $label);
    }

    /**
     * Validate form
     *
     * @param WidgetForm $form
     * @return void
     */
    public function validate(WidgetForm $form, array $values, bool $isCreate, $id)
    {
        return $form->validationMessageArray($values);
    }

    /**
     * Get content
     *
     * @return Content
     */
    public function getContent() : Content
    { 
        $content = new Content();
        if(!is_nullorempty($title = $this->plugin->getOption('title', $this->getTitle()))){
            $content->header($title);
        }
        if(!is_nullorempty($description = $this->plugin->getOption('description', $this->getDescription()))){
            $content->description($description);
        }
        if(!is_nullorempty($headericon = $this->plugin->getOption('icon', $this->getIcon()))){
            $content->headericon($headericon);
        }

        return $content;
    }

    /**
     * Get content title
     *
     * @return  string
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get content description
     *
     * @return  string
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get content icon
     *
     * @return  string
     */ 
    public function getIcon()
    {
        return $this->icon;
    }
}
