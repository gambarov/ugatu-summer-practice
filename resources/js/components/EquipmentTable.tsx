import React, { useEffect, useMemo } from 'react';
import { DataTable, DataTableFilterMeta } from 'primereact/datatable';
import { Column, ColumnFilterElementTemplateOptions } from 'primereact/column';
import { Button } from 'primereact/button';
import { InputText } from 'primereact/inputtext';
import { MultiSelect } from 'primereact/multiselect';
import { FilterMatchMode } from 'primereact/api';
import { MultiSelectChangeParams } from 'primereact/multiselect';
import { Toolbar } from 'primereact/toolbar';
import { ConfirmDialog } from 'primereact/confirmdialog';
import { Dialog } from 'primereact/dialog';
import { Dropdown } from 'primereact/dropdown';
import PaginatorTemplate from './templates/Paginator';

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

    const emptyEquipment = useMemo(() => {
        return {
            id: 0,
            name: '',
            type: ''
        };
    }, []);

    const [equipment, setEquipment] = React.useState<EquipmentData>(emptyEquipment);
    const [EquipmentDialog, setEquipmentDialog] = React.useState<boolean>(false);
    const [deleteEquipmentDialog, setDeleteEquipmentDialog] = React.useState<boolean>(false);
    const [deleteEquipmentsDialog, setDeleteEquipmentsDialog] = React.useState<boolean>(false);

    const [selectedEquipments, setSelectedEquipments] = React.useState<EquipmentData[]>([]);

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

    const deleteEquipment = () => {
        setDeleteEquipmentDialog(false);
        setData(data.filter(eq => eq.id !== equipment.id));
        setEquipment(emptyEquipment);
    }

    const deleteSelectedEquipments = () => {
        setDeleteEquipmentsDialog(false);
        setData(data.filter(eq => !selectedEquipments.includes(eq)));
        setSelectedEquipments([]);
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

    const leftToolbarTemplate = () => {
        return (
            <React.Fragment>
                <Button label="Добавить" icon="pi pi-plus" className="p-button-primary mr-3"
                    onClick={() => {
                        setEquipment(emptyEquipment);
                        setEquipmentDialog(true)
                    }} />
                <Button label="Удалить выбранное" icon="pi pi-trash"
                    className="p-button-danger" onClick={() => { setDeleteEquipmentsDialog(true) }}
                    disabled={!selectedEquipments || !selectedEquipments.length} />
            </React.Fragment>
        )
    }

    const actionBodyTemplate = (rowData: EquipmentData) => {
        return (
            <div>
                <Button icon="pi pi-eye" className="p-button-rounded p-button-primary mr-2" />
                <Button icon="pi pi-pencil" className="p-button-rounded p-button-success mr-2" onClick={() => {
                    setEquipment(rowData);
                    setEquipmentDialog(true);
                }} />
                <Button icon="pi pi-trash" className="p-button-rounded p-button-danger" onClick={() => {
                    setEquipment(rowData);
                    setDeleteEquipmentDialog(true);
                }} />
            </div>
        );
    };

    const equipmentDialogFooter = () => {
        return (
            <React.Fragment>
                <Button label="Отмена" icon="pi pi-times" className="p-button-secondary" onClick={() => {
                    setEquipmentDialog(false);
                }} />
                <Button label="Сохранить" icon="pi pi-check" className="p-button-primary" onClick={() => {
                    setEquipmentDialog(false);
                    if (equipment.id) {
                        const newData = [...data];
                        const index = newData.findIndex(eq => eq.id === equipment.id);
                        newData[index] = equipment;
                        setData(newData);
                    }
                    else {
                        setData([...data, equipment]);
                    }
                    setEquipment(emptyEquipment);
                }} />
            </React.Fragment>
        );
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

    return (
        <>
            <Toolbar className="mb-3" left={leftToolbarTemplate}></Toolbar>

            <DataTable value={data}
                sortMode='multiple' removableSort
                header={header} responsiveLayout="scroll"
                resizableColumns columnResizeMode="fit"
                selection={selectedEquipments} onSelectionChange={(e) => setSelectedEquipments(e.value)}
                emptyMessage='МТО отсутствуют...' showGridlines dataKey='id'
                filterDisplay='row' filters={filters} globalFilterFields={['name', 'type']} onFilter={(e) => { setFilters(e.filters); }}
                paginator rows={10} paginatorTemplate={PaginatorTemplate}>
                <Column selectionMode="multiple" headerStyle={{ width: '3rem' }} exportable={false}></Column>
                <Column field="id" header="#" sortable />
                <Column field="name" header="Название" sortable
                    filter filterPlaceholder='Поиск по названию...' showFilterMenu={false} />
                <Column field='type' header="Тип" sortable
                    filter filterElement={typeFilterTemplate} showFilterMenu={false} />
                <Column body={actionBodyTemplate} exportable={false} style={{ minWidth: '8rem' }}></Column>
            </DataTable>

            <ConfirmDialog visible={deleteEquipmentDialog} onHide={() => setDeleteEquipmentDialog(false)} message={`Вы уверены, что хотите удалить ${equipment.name}?`}
                header="Подтверждение действия" icon="pi pi-info-circle" acceptClassName='p-button-danger' accept={deleteEquipment} />

            <ConfirmDialog visible={deleteEquipmentsDialog} onHide={() => setDeleteEquipmentsDialog(false)} message={`Вы уверены, что хотите удалить выбранные МТО?`}
                header="Подтверждение действия" icon="pi pi-info-circle" acceptClassName='p-button-danger' accept={deleteSelectedEquipments} />

            <Dialog visible={EquipmentDialog} style={{ width: '450px' }}
                header="МТО" modal className="p-fluid"
                footer={equipmentDialogFooter} onHide={() => setEquipmentDialog(false)}>
                <div className="field">
                    <label htmlFor="name">Наименование МТО</label>
                    <InputText id="name" value={equipment.name} onChange={(e) => setEquipment({ ...equipment, 'name': e.target.value })}
                        required autoFocus />
                </div>
                <div className="field">
                    <label htmlFor="type">Тип</label>
                    <Dropdown value={equipment.type} options={types} onChange={(e) => setEquipment({ ...equipment, 'type': e.target.value })} placeholder="Выберите тип МТО" />
                </div>
            </Dialog>
        </>
    );
}

export default EquipmentTable;