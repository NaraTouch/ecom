<?php

namespace AppModule\Admin\DataGrids;

use Illuminate\Support\Facades\DB;
use AppModule\Ui\DataGrid\DataGrid;

class CartRuleCouponDataGrid extends DataGrid
{
    /**
     * Index.
     *
     * @var string
     */
    protected $index = 'id';

    /**
     * Sort order.
     *
     * @var string
     */
    protected $sortOrder = 'desc';

    /**
     * Prepare query builder.
     *
     * @return void
     */
    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('cart_rule_coupons')
            ->addSelect('id', 'code', 'created_at', 'expired_at', 'times_used')
            ->where('cart_rule_coupons.cart_rule_id', request('id'));

        $this->setQueryBuilder($queryBuilder);
    }

    /**
     * Add columns.
     *
     * @return void
     */
    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('admin::app.datagrid.id'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'code',
            'label'      => trans('admin::app.datagrid.coupon-code'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'created_at',
            'label'      => trans('admin::app.datagrid.created-date'),
            'type'       => 'datetime',
            'sortable'   => true,
            'searchable' => false,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'expired_at',
            'label'      => trans('admin::app.datagrid.expiration-date'),
            'type'       => 'datetime',
            'sortable'   => true,
            'searchable' => false,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'times_used',
            'label'      => trans('admin::app.datagrid.times-used'),
            'type'       => 'number',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);
    }

    /**
     * Prepare mass actions.
     *
     * @return void
     */
    public function prepareMassActions()
    {
        $this->addMassAction([
            'type'   => 'delete',
            'action' => route('admin.cart_rules.coupons.mass_delete'),
            'label'  => trans('admin::app.datagrid.delete'),
            'method' => 'POST',
        ]);
    }
}
