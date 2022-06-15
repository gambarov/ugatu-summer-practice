import React from 'react'
import Container from 'react-bootstrap/Container';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';
import ListGroup from 'react-bootstrap/ListGroup';
import EquipmentTable, { EquipmentData } from '../EquipmentTable';
import { Column } from 'react-table';

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

    const data: EquipmentData[] = React.useMemo(() => [
        { id: 1, name: 'Прибор2', type: 'Тип2' },
        { id: 1, name: 'Прибор2', type: 'Тип2' },
        { id: 1, name: 'Прибор2', type: 'Тип2' },
        { id: 1, name: 'Прибор2', type: 'Тип2' },
        { id: 1, name: 'Прибор2', type: 'Тип2' },
        { id: 1, name: 'Прибор2', type: 'Тип2' },
        { id: 1, name: 'Прибор2', type: 'Тип2' },
        { id: 1, name: 'Прибор2', type: 'Тип2' },
    ], []);

    return (
        <Container>
            <Row className='mt-3'>
                <Col md='3'>
                    <ListGroup role={'button'}>
                        <ListGroup.Item>Комплекты</ListGroup.Item>
                        <ListGroup.Item active>Обеспечение</ListGroup.Item>
                        <ListGroup.Item>Размещение</ListGroup.Item>
                    </ListGroup>
                </Col>
                <Col md='9'>
                    <EquipmentTable columns={headers} data={data} />
                </Col>
            </Row>
        </Container>
    )
}

export default Equipment