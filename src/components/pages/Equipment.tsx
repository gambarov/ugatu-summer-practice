import React, { useState } from 'react'
import { Form, Container, Button, Col, FormControl, Pagination, Row } from 'react-bootstrap'
import { Column } from 'react-table';
import AddItemModal from '../AddItemModal'
import EquipmentTable, { EquipmentData } from '../EquipmentTable';

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

const Equipment = () => {
    const headers: Column<EquipmentData>[] = React.useMemo(() => [
        {
            Header: "#",
            accessor: "id"
        },
        {
            Header: "Наименование",
            accessor: "name"
        },
        {
            Header: "Тип",
            accessor: "type",
        }
    ], []);

    const [data, setData] = useState<EquipmentData[]>(generateEquipmentData(15));

    const [show, setShow] = useState(false);

    const [form, setForm] = useState<EquipmentData>({
        id: 0,
        name: '',
        type: 'ПО'
    });

    const handleAddEquipment = () => {
        addEquipment({...form, id: data.length + 1});
    };

    const addEquipment = (equipment: EquipmentData) => {
        setData([...data, equipment]);
    }

    const updateEquipment = (equipment: EquipmentData) => {
        setData(data.map(item => item.id === equipment.id ? equipment : item));
    }

    const deleteEquipment = (id: number) => {
        setData(data.filter(item => item.id !== id));
    }

    return (
        <>
            <Row>
                <Col md='12'>
                    <EquipmentTable columns={headers} data={data} />
                </Col>
            </Row>
            <Row>
                <Col md='3'>
                    <Button variant='primary' onClick={() => { setShow(true) }}>Добавить</Button>
                </Col>
            </Row>
            <AddItemModal title='Добавление обеспечения' show={show} setShow={setShow} onAction={handleAddEquipment}>
                <Form>
                    <Form.Group className="mb-3" controlId="formBasicEmail">
                        <Form.Label>Название</Form.Label>
                        <Form.Control
                            type="text"
                            placeholder="Введите название обеспечения"
                            onChange={(e) => { setForm({ ...form, name: e.target.value }) }}
                            autoFocus
                        />
                    </Form.Group>

                    <Form.Group className="mb-3" controlId="formBasicPassword">
                        <Form.Label>Тип</Form.Label>
                        <Form.Select aria-label="Default select example"
                            onChange={
                                (e) => { setForm({ ...form, type: e.target.value }) }
                            }>
                            <option disabled>Выберите тип обеспечения</option>
                            <option value="ПО">ПО</option>
                            <option value="АО">АО</option>
                        </Form.Select>
                    </Form.Group>
                </Form>
            </AddItemModal>
        </>
    )
}

export default Equipment