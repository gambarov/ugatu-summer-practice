import React from 'react'
import { Modal, Button } from 'react-bootstrap'

interface Props {
    show: boolean;
    setShow: (show: boolean) => void;
    title: string;
    children: React.ReactNode;
    onAction: () => void;
}

const AddItemModal: React.FC<Props> = ({ show, setShow, title, children, onAction }) => {
    return (
        <Modal show={show} onHide={() => { setShow(false) }} centered>
            <Modal.Header closeButton>
                <Modal.Title>{title}</Modal.Title>
            </Modal.Header>

            <Modal.Body>
                {children}
            </Modal.Body>

            <Modal.Footer>
                <Button variant="secondary" onClick={() => { setShow(false) }}>Закрыть</Button>
                <Button variant="primary" onClick={() => {
                    onAction();
                    setShow(false);
                }}>Сохранить</Button>
            </Modal.Footer>
        </Modal>
    )
}

export default AddItemModal