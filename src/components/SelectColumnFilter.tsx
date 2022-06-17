import React from 'react'
import { Form } from 'react-bootstrap';
import { Column } from 'react-table'

interface Props {
    column: Column<any>;
}

const SelectColumnFilter: React.FC<any> = ({ column }) => {
    const { filterValue, setFilter, preFilteredRows, id } = column;

    const options = React.useMemo(() => {
        const options = new Set<string>()
        preFilteredRows.forEach((row: any) => {
            options.add(row.values[id])
        })
        return Array.from(options.values());
    }, [id, preFilteredRows])

    return (
        <Form.Select 
            value={filterValue}
            onChange={e => {
                setFilter(e.target.value || undefined)
            }}>
            <option value="" selected>Все</option>
            {options.map((option, i) => (
                <option key={i} value={option}>
                    {option}
                </option>
            ))}
        </Form.Select>
    )
}

export default SelectColumnFilter