import React from 'react'
import { Tab, Row, Col, ListGroup, Container } from 'react-bootstrap'
import Equipment from './Equipment'

const Main = () => {
    return (
        <Container>
            <Tab.Container id="main-list-groups" defaultActiveKey="#mto">
                <Row>
                    <Col sm={3}>
                        <ListGroup role={'button'} className='mb-3 mb-sm-0'>
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
                                <Equipment/>
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