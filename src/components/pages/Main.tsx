import React from 'react'
import { Tab, Row, Col, ListGroup, Container } from 'react-bootstrap'
import EquipmentTable, { EquipmentData } from '../EquipmentTable'
import { Column } from 'react-table';

const Main = () => {
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
            <Tab.Container id="main-list-groups" defaultActiveKey="#mto">
                <Row>
                    <Col sm={3}>
                        <ListGroup role={'button'}>
                            <ListGroup.Item action href="#mto">
                                МТО
                            </ListGroup.Item>
                            <ListGroup.Item action href="#sets">
                                Комплекты
                            </ListGroup.Item>
                            <ListGroup.Item action href="#audiences">
                                Аудитории
                            </ListGroup.Item>
                        </ListGroup>
                    </Col>
                    <Col sm={9}>
                        <Tab.Content>
                            <Tab.Pane eventKey="#mto">
                                <EquipmentTable columns={headers} data={data} />
                            </Tab.Pane>
                            <Tab.Pane eventKey="#sets">
                                ...
                            </Tab.Pane>
                            <Tab.Pane eventKey="#audiences">
                                ...
                            </Tab.Pane>
                        </Tab.Content>
                    </Col>
                </Row>
            </Tab.Container>
        </Container>
    )
}

export default Main