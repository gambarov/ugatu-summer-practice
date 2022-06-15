import React from 'react';
import Table from 'react-bootstrap/Table';
import { useTable, Column } from 'react-table'

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
    // Use the state and functions returned from useTable to build your UI
    const {
        getTableProps,
        getTableBodyProps,
        headerGroups,
        rows,
        prepareRow,
    } = useTable({
        columns,
        data,
    })

    return (
        <Table {...getTableProps()} className='table table-bordered'>
            <thead className='table table-primary'>
                {headerGroups.map((headerGroup) => {
                    const { key, ...restHeadGroupProps } = headerGroup.getHeaderGroupProps();
                    return (<tr {...restHeadGroupProps} key={key}>
                        {headerGroup.headers.map(column => {
                            const { key, ...restColumnProps } = column.getHeaderProps();
                            return (
                                <th {...restColumnProps} key={key}>{column.render('Header')}</th>
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
    )
}

export default EquipmentTable;