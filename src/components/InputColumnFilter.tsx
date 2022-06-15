import React from 'react';
import { Form } from 'react-bootstrap';

const InputColumnFilter = ({ column }: any) => {
    const { filterValue, setFilter } = column;

    return (
        <Form.Control
            type="text"
            value={filterValue || ''}
            onChange={e => {
                setFilter(e.target.value || undefined)
            }}
            placeholder={`Введите для поиска...`}
        />

    )
}

export default InputColumnFilter;