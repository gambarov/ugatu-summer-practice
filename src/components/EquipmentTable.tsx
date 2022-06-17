import React from 'react';
import Table from 'react-bootstrap/Table';
import { useTable, useSortBy, useFilters, Column } from 'react-table'
import { Button, Row, Col, Form, Modal } from 'react-bootstrap';
import { TrashFill, PencilFill, SortUp, SortDownAlt } from 'react-bootstrap-icons';
import AddItemModal from './AddItemModal';

export interface EquipmentData {
    id: number;
    name: string;
    type: string;
}

interface Props {
    columns: Column<EquipmentData>[];
    data: EquipmentData[];
    addEquipment: (equipment: EquipmentData) => void;
    updateEquipment: (equipment: EquipmentData) => void;
    deleteEquipment: (id: number) => void;
}

const EquipmentTable: React.FC<Props> = ({ columns, data, updateEquipment, deleteEquipment }) => {
    const [show, setShow] = React.useState(false);
    const [showDeleteModal, setShowDeleteModal] = React.useState(false);

    const [form, setForm] = React.useState<EquipmentData>({
        id: 0,
        name: '',
        type: 'ПО'
    });

    const tableHooks = (hooks: any) => {
        hooks.visibleColumns.push((columns: Column<EquipmentData>[]) => [
            ...columns,
            {
                id: 'actions',
                accessor: 'actions',
                Header: 'Действия',
                disableFilters: true,
                Cell: ({ row }: any) => (
                    <Row>
                        <Col>
                            <Button onClick={
                                () => {
                                    setForm({ ...row.original });
                                    setShow(true);
                                }}>
                                <PencilFill />
                            </Button>
                        </Col>
                        <Col>
                            <Button variant='danger' onClick={
                                () => {
                                    setForm({ ...row.original });
                                    setShowDeleteModal(true);
                                }}>
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
                <thead className='bg-primary text-light'>
                    {headerGroups.map((headerGroup) => {
                        const { key, ...restHeadGroupProps } = headerGroup.getHeaderGroupProps();
                        return (<tr {...restHeadGroupProps} key={key}>
                            {headerGroup.headers.map(column => {
                                const { key, ...restColumnProps } = column.getHeaderProps();
                                return (
                                    <th {...restColumnProps} key={key}>
                                        <Row className='align-items-center'>
                                            <Col md='6'>
                                                <span {...column.getSortByToggleProps()}>
                                                    {column.render('Header')}
                                                    {column.isSorted ? (column.isSortedDesc ? <SortUp /> : <SortDownAlt />) : null}
                                                </span>
                                            </Col>
                                            <Col md='6'>
                                                <div>{column.canFilter ? column.render('Filter') : null}</div>
                                            </Col>
                                        </Row>
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

            <AddItemModal title='Обновление обеспечения' show={show} setShow={setShow} onAction={() => { updateEquipment(form) }}>
                <Form>
                    <Form.Group className="mb-3">
                        <Form.Label>Название</Form.Label>
                        <Form.Control
                            type="text"
                            placeholder="Введите название обеспечения"
                            onChange={(e) => { setForm({ ...form, name: e.target.value }) }}
                            value={form.name}
                            autoFocus
                        />
                    </Form.Group>

                    <Form.Group className="mb-3">
                        <Form.Label>Тип</Form.Label>
                        <Form.Select aria-label="Default select example"
                            onChange={
                                (e) => { setForm({ ...form, type: e.target.value }) }
                            }
                            value={form.type}
                        >
                            <option disabled>Выберите тип обеспечения</option>
                            <option value="ПО">ПО</option>
                            <option value="АО">АО</option>
                        </Form.Select>
                    </Form.Group>
                </Form>
            </AddItemModal>

            <Modal show={showDeleteModal} onHide={() => { setShowDeleteModal(false) }} centered>
                <Modal.Header closeButton>
                    <Modal.Title>Удаление записи</Modal.Title>
                </Modal.Header>

                <Modal.Body>
                    Вы точно хотите удалить запись об обеспечении?
                </Modal.Body>

                <Modal.Footer>
                    <Button variant="secondary" onClick={() => { setShow(false) }}>Нет</Button>
                    <Button variant="primary" onClick={() => {
                        deleteEquipment(form.id);
                        setShowDeleteModal(false);
                    }}>Да</Button>
                </Modal.Footer>
            </Modal>
        </>
    )
}

export default EquipmentTable;