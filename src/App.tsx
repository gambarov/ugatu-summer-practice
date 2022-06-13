import React from 'react';
import { Column } from 'react-table';
import EquipmentTable, { EquipmentData } from './components/EquipmentTable';

function App() {
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
	], []);

	return (
		<EquipmentTable columns={headers} data={data} />
	);
}

export default App;
