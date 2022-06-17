import React, { useEffect, useMemo } from 'react';
import { DataTable, DataTableFilterMeta } from 'primereact/datatable';
import { Column, ColumnFilterElementTemplateOptions } from 'primereact/column';
import { Button } from 'primereact/button';
import { InputText } from 'primereact/inputtext';
import { MultiSelect } from 'primereact/multiselect';
import { FilterMatchMode } from 'primereact/api';
import { MultiSelectChangeParams } from 'primereact/multiselect';
import { Row, Col } from 'react-bootstrap';
import { PaginatorCurrentPageReportOptions, PaginatorRowsPerPageDropdownOptions, PaginatorTemplate } from 'primereact/paginator';
import { Dropdown } from 'primereact/dropdown';
import { Toolbar } from 'primereact/toolbar';

function generateEquipmentData(count: number): EquipmentData[] {
    const data: EquipmentData[] = [];
    for (let i = 0; i < count; i++) {
        data.push({
            id: i + 1,
            name: `Обеспечение${i + 1}`,
            type: Math.random() > 0.5 ? 'ПО' : 'АО'
        });
    }
    return data;
}

export interface EquipmentData {
    id: number;
    name: string;
    type: string;
}


const EquipmentTable: React.FC = () => {
    const [data, setData] = React.useState<EquipmentData[]>(generateEquipmentData(15));

    const [filters, setFilters] = React.useState<DataTableFilterMeta>({});
    const [globalFilterValue, setGlobalFilterValue] = React.useState<string>('');

    const types = useMemo(() => ['ПО', 'АО'], []);

    useEffect(() => {
        resetFilters();
    }, []);

    const resetFilters = () => {
        setFilters({
            'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
            'name': { value: null, matchMode: FilterMatchMode.CONTAINS },
            'type': { value: null, matchMode: FilterMatchMode.IN },
        });
        setGlobalFilterValue('');
    }

    const onGlobalFilterChange = (event: React.ChangeEvent<HTMLInputElement>) => {
        const value = event.target.value;
        // FIXME: не стоит перезаписывать global полностью
        // Следует перезаписывать только его value
        const newFilters = { ...filters, 'global': { value, matchMode: FilterMatchMode.CONTAINS } };
        setFilters(newFilters);
        setGlobalFilterValue(value);
    }

    const typeFilterTemplate = (options: ColumnFilterElementTemplateOptions) => {
        return <MultiSelect display="chip" options={types}
            value={options.value} onChange={(e: MultiSelectChangeParams) => { options.filterApplyCallback(e.value); console.log(filters) }}
            placeholder="Все" className="p-column-filter" />;
    }

    const leftToolbarTemplate = () => {
        return (
            <React.Fragment>
                <Button label="Добавить" icon="pi pi-plus" className="p-button-success mr-3" />
                <Button label="Удалить выбранное" icon="pi pi-trash" className="p-button-danger" />
            </React.Fragment>
        )
    }

    const renderHeader = () => {
        return (
            <div>
                <span className="p-input-icon-left">
                    <i className="pi pi-search" />
                    <InputText className='mr-3' value={globalFilterValue} onChange={onGlobalFilterChange} placeholder="Поиск..." />
                </span>
                <Button type="button" icon="pi pi-filter-slash" label="Очистить" onClick={resetFilters} />
            </div>
        )
    }

    const header = useMemo(() => renderHeader(), [globalFilterValue]);

    const paginatorTemplate: PaginatorTemplate = {
        layout: 'CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown',
        'RowsPerPageDropdown': (options: PaginatorRowsPerPageDropdownOptions) => {
            const dropdownOptions = [
                { label: 10, value: 10 },
                { label: 20, value: 20 },
                { label: 50, value: 50 },
                { label: 'Все', value: options.totalRecords },
            ];

            return <Dropdown value={options.value} options={dropdownOptions} onChange={options.onChange} />;
        },
        'CurrentPageReport': (options: PaginatorCurrentPageReportOptions) => {
            return (
                <span style={{ color: 'var(--text-color)', userSelect: 'none', width: '120px', textAlign: 'center' }}>
                    {options.first} - {options.last} из {options.totalRecords}
                </span>
            )
        },
        'FirstPageLink': (options) => {
            return options.element;
        },
        'LastPageLink': (options) => {
            return options.element;
        },
        'JumpToPageInput': (options) => {
            return options.element;
        },
        'NextPageLink': (options) => {
            return options.element;
        },
        'PrevPageLink': (options) => {
            return options.element;
        },
        'PageLinks': (options) => {
            return options.element;
        }
    };

    return (
        <>
            <Toolbar className="mb-4" left={leftToolbarTemplate}></Toolbar>

            <DataTable value={data}
                sortMode='multiple' removableSort
                header={header} responsiveLayout="scroll"
                resizableColumns columnResizeMode="fit"
                emptyMessage='МТО отсутствуют...' showGridlines dataKey='id'
                filterDisplay='row' filters={filters} globalFilterFields={['name', 'type']}
                paginator rows={10} paginatorTemplate={paginatorTemplate}>
                <Column field="id" header="#" sortable />
                <Column field="name" header="Название" sortable
                    filter filterPlaceholder='Поиск по названию...' showFilterMenu={false} />
                <Column field='type' header="Тип" sortable
                    filter filterElement={typeFilterTemplate} showFilterMenu={false} />
            </DataTable>
        </>
    );
}

export default EquipmentTable;