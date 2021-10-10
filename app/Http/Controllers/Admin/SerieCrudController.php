<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SerieRequest;
use App\Models\Serie;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SerieCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SerieCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;

    
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkCloneOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Serie::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/serie');
        CRUD::setEntityNameStrings('serie', 'series');

        $this->crud->allowAccess('show');
        $this->crud->enableExportButtons();
        // $this->crud->enableDetailsRow();

        $this->crud->addFields($this->getFieldsData(TRUE));

        $this->crud->addFilter(
            [
                'name'  => 'category_id',
                'type'  => 'select2',
                'label' => 'Status'
            ],
            function () {
                return Serie::select('category_id')->distinct()->get()->pluck('category_id', 'category_id')->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', 'category_id', $value);
            }
        );

    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); // columns
        
        // CRUD::addColumn('name');
        $this->crud->addColumns($this->getColumnsData(TRUE));
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }
    private function getColumnsData($show = FALSE)
    {
        return [
            [
                'name' => 'name',
                'label' => 'Title',
                'type' => 'text',
            ],
            [
                'name' => 'category',
                'label' => 'Category',
                'type'     => 'relationship',
                'function' => function ($entry) {
                    return  $entry->name;
                }
            ],
        ];
    }
    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(SerieRequest::class);

        CRUD::setFromDb(); // fields

        // CRUD::field(
        //     [
        //         'name' => 'Category',
        //         'label' => 'category_id',
        //         'type'     => 'relationship',
        //         'function' => function ($entry) {
        //             return  $entry->name;
        //         }
        //     ],);
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    protected function setupShowOperation()
    {
        // by default the Show operation will try to show all columns in the db table,
        // but we can easily take over, and have full control of what columns are shown,
        // by changing this config for the Show operation 
        $this->crud->set('show.setFromDb', false);
        $this->crud->addColumns(['name', 'category_id']);
        
    }
    private function getFieldsData($show = FALSE)
    {
        return [
            [
                'name' => 'name',
                'label' => 'Title',
                'type' => 'text',
            ],
            [
                'label' => "Category",
                'type' => 'select',
                'name' => 'category_id',
                'entity' => 'category',
                'attribute' => 'name',
                'model' => 'App\Models\Category',
            ],
            // [
            //     'name' => 'category_id',
            //     'label' => 'Category',
            //     'type' => 'number',
            // ],
        ];
    }
    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
