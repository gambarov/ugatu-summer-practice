import React from 'react';
import MyNavbar from './components/Navbar';
import Main from './components/pages/Main';
import './App.scss';
import "primereact/resources/themes/lara-light-indigo/theme.css";  //theme
import "primereact/resources/primereact.min.css";                  //core css
import "primeicons/primeicons.css";                                //icons

function App() {
	return (
		<>
			<MyNavbar />
			<Main />
		</>
	);
}

export default App;
