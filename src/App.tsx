import React from 'react';
// import './App.scss';
import "primereact/resources/themes/bootstrap4-light-blue/theme.css";  //theme
import "primereact/resources/primereact.min.css";                  //core css
import "primeicons/primeicons.css";                                //icons
import EquipmentTable from './components/EquipmentTable';
import MainMenubar from './components/MainMenubar';

function App() {
	return (
		<>
			<MainMenubar/>
			<EquipmentTable/>
		</>
	);
}

export default App;
