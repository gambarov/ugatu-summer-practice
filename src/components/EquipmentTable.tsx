import React from 'react';
import Table from 'react-bootstrap/Table';
import { useTable, useSortBy, useFilters, Column } from 'react-table'
import { Button, Row, Col } from 'react-bootstrap';
import { TrashFill, PencilFill, SortUp, SortDownAlt } from 'react-bootstrap-icons';

export interface EquipmentData {
    id: number;
    name: string;
    type: string;
}

interface Props {
    columns: Column<EquipmentData>[];
    data: EquipmentData[];
    // addEquipment: (equipment: EquipmentData) => void;
    // updateEquipment: (equipment: EquipmentData) => void;
    // deleteEquipment: (id: number) => void;
}

const EquipmentTable: React.FC<Props> = ({ columns, data }) => {
    const tableHooks = (hooks: any) => {
        hooks.visibleColumns.push((columns: Column<EquipmentData>[]) => [
            ...columns,
            {
                id: 'actions',
                accessor: 'actions',
                Header: 'Действия',
                disableFilters: true,
                Cell: () => (
                    <Row>
                        <Col sm='4' md='2'>
                            <Button>
                                <PencilFill />
                            </Button>
                        </Col>
                        <Col sm='4' md='2'>
                            <Button>
                                <TrashFill />
                            </Button>
                        </Col>
                    </Row>
                )
            }
        ]);
    }

    const {
        getTableProps,
        getTableBodyProps,
        headerGroups,
        rows,
        prepareRow,
    } = useTable({
        columns,
        data,
    },
        tableHooks, 
        useFilters,
        useSortBy);

    return (
        <>
            <Table {...getTableProps()} bordered className='align-middle'>
                <thead className='table-primary'>
                    {headerGroups.map((headerGroup) => {
                        const { key, ...restHeadGroupProps } = headerGroup.getHeaderGroupProps();
                        return (<tr {...restHeadGroupProps} key={key}>
                            {headerGroup.headers.map(column => {
                                const { key, ...restColumnProps } = column.getHeaderProps(column.getSortByToggleProps());
                                return (
                                    <th {...restColumnProps} key={key} className='w-auto'>
                                        {column.render('Header')}
                                        {column.isSorted ? (column.isSortedDesc ? <SortUp /> : <SortDownAlt />) : null}
                                    </th>
                                )
                            })}
                        </tr>)
                    })}
                </thead>
                <tbody {...getTableBodyProps()}>
                    {rows.map((row) => {
                        prepareRow(row)
                        const { key, ...restRowProps } = row.getRowProps();
                        return (
                            <tr {...restRowProps} key={key}>
                                {row.cells.map(cell => {
                                    const { key, ...restCellProps } = cell.getCellProps();
                                    return <td {...restCellProps} key={key}>{cell.render('Cell')}</td>
                                })}
                            </tr>
                        )
                    })}
                </tbody>
            </Table>
        </>
    )
}

export default EquipmentTable;