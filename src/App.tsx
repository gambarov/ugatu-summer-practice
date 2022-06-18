import React, { useMemo, useRef } from 'react';
// import './App.scss';
import "primereact/resources/themes/bootstrap4-light-blue/theme.css";  	// Тема
import "primereact/resources/primereact.min.css";                  		// Ядро
import "primeicons/primeicons.css";                                		// Иконки
import EquipmentTable from './components/EquipmentTable';
import MainMenubar from './components/MainMenubar';
import MainMenu from './components/MainMenu';
import MainTabView, { CustomTabPanel, MainTabViewHandle } from './components/MainTabView';
import { Card } from 'primereact/card';

function App() {

	const mainMenuRef = useRef<MainTabViewHandle>(null);

	const tabPanelItems: CustomTabPanel[] = useMemo(() => [
		{ id: 1, header: 'МТО', content: <EquipmentTable /> },
		{ id: 2, header: 'Комплекты', content: <div>HELLO!</div> },
		{ id: 3, header: 'Аудитории', content: <div>22222</div> },
	], []);

	const onMenuItemClick = (label: string) => {
		tabPanelItems.map(tabPanel => {
			if (tabPanel.header === label) {
				mainMenuRef.current?.addTabPanel(tabPanel);
			}
		});
	}

	return (
		<>
			<MainMenubar />
			<Card>
				<div className="grid flex flex-nowrap justify-content-between">
					<div className="col-3 mr-3">
						<MainMenu onMenuItemClick={onMenuItemClick} />
					</div>
					<div className="col-9 pr-4">
						<MainTabView ref={mainMenuRef} />
					</div>
				</div>
			</Card>
		</>
	);
}

export default App;
