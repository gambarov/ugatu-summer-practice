import React, { useEffect, useMemo } from 'react';
import { TrashFill, PencilFill, SortUp, SortDownAlt } from 'react-bootstrap-icons';
import { DataTable, DataTableFilterMeta } from 'primereact/datatable';
import { Column, ColumnFilterElementTemplateOptions } from 'primereact/column';
import { Button } from 'primereact/button';
import { InputText } from 'primereact/inputtext';
import { MultiSelect } from 'primereact/multiselect';
import { FilterMatchMode } from 'primereact/api';
import { MultiSelectChangeParams } from 'primereact/multiselect';
import { Row, Col } from 'react-bootstrap';

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
            value={options.value} onChange={(e: MultiSelectChangeParams) => { options.filterApplyCallback(e.value); }}
            placeholder="Все" className="p-column-filter" />;
    }

    const renderHeader = () => {
        return (
            <div>
                <Row>
                    <Col md='auto'>
                        <span className="p-input-icon-left">
                            <i className="pi pi-search" />
                            <InputText value={globalFilterValue} onChange={onGlobalFilterChange} placeholder="Поиск..." />
                        </span>
                    </Col>
                    <Col>
                        <Button type="button" icon="pi pi-filter-slash" label="Очистить" className="p-button-outlined" onClick={resetFilters} />

                    </Col>
                </Row>
            </div>
        )
    }

    const header = useMemo(() => renderHeader(), [globalFilterValue]);

    return (
        <DataTable value={data} sortMode='multiple' removableSort header={header} responsiveLayout="scroll"
            emptyMessage='МТО отсутствуют...' showGridlines dataKey='id'
            filterDisplay='row' filters={filters} globalFilterFields={['name', 'type']}
            paginator rows={5} rowsPerPageOptions={[5, 10, 25]}
            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
            currentPageReportTemplate="Показано {first} с {last} из {totalRecords}">
            <Column field="id" header="#" sortable />
            <Column field="name" header="Название" sortable
                filter filterPlaceholder='Поиск по названию...' showFilterMenu={false} />
            <Column field='type' header="Тип" sortable
                filter filterElement={typeFilterTemplate} showFilterMenu={false} />
        </DataTable>
    );
}

export default EquipmentTable;