import React from 'react';
import Container from 'react-bootstrap/Container';
import Table from 'react-bootstrap/Table';
import { useTable, Column } from 'react-table'
import Button from 'react-bootstrap/Button';
import Form from 'react-bootstrap/Form';
import FormControl from 'react-bootstrap/FormControl';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';
import Pagination from 'react-bootstrap/Pagination';

export interface EquipmentData {
    id: number;
    name: string;
    type: string;
}

interface Props {
    columns: Column<EquipmentData>[];
    data: EquipmentData[];
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

    console.log(rows);

    return (
        <Container>
            <Row className='mb-3'>
                <Col md='6'>
                    <Button variant='primary'>Фильтрация</Button>
                </Col>
                <Col md='6'>
                    <Form className="d-flex">
                        <FormControl
                            type="search"
                            placeholder="Search"
                            className="me-2"
                            aria-label="Search"
                        />
                        <Button variant="primary">Поиск</Button>
                    </Form>
                </Col>
            </Row>
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
            <Row className='justify-content-md-between'>
                <Col md='3'>
                    <Button variant='primary'>Добавить</Button>
                </Col>
                <Col md='9'>
                    <Pagination>
                        <Pagination.First />
                        <Pagination.Prev />
                        <Pagination.Item>{1}</Pagination.Item>
                        <Pagination.Ellipsis />

                        <Pagination.Item>{10}</Pagination.Item>
                        <Pagination.Item>{11}</Pagination.Item>
                        <Pagination.Item active>{12}</Pagination.Item>
                        <Pagination.Item>{13}</Pagination.Item>
                        <Pagination.Item disabled>{14}</Pagination.Item>

                        <Pagination.Ellipsis />
                        <Pagination.Item>{20}</Pagination.Item>
                        <Pagination.Next />
                        <Pagination.Last />
                    </Pagination>
                </Col>
            </Row>
        </Container>
    )
}

export default EquipmentTable;