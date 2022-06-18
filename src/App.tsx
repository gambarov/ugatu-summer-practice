import React, { useMemo, useRef } from 'react';
// import './App.scss';
import "primereact/resources/themes/nova/theme.css";  					// Тема
import "primereact/resources/primereact.min.css";                  		// Ядро
import "primeicons/primeicons.css";                                		// Иконки
import EquipmentTable from './components/EquipmentTable';
import AppMenubar from './components/AppMenubar';
import AppMenu from './components/AppMenu';
import AppTabView, { AppTabPanel, AppTabViewHandle } from './components/AppTabView';
import { Card } from 'primereact/card';

function App() {

	const menuRef = useRef<AppTabViewHandle>(null);

	const tabPanelItems: AppTabPanel[] = useMemo(() => [
		{ id: 1, header: 'МТО', content: <EquipmentTable /> },
		{ id: 2, header: 'Комплекты', content: <div>HELLO!</div> },
		{ id: 3, header: 'Аудитории', content: <div>22222</div> },
	], []);

	const onMenuItemClick = (label: string) => {
		tabPanelItems.map(tabPanel => {
			if (tabPanel.header === label) {
				menuRef.current?.addTabPanel(tabPanel);
			}
		});
	}

	return (
		<>
			<AppMenubar />
			<Card>
				<div className="grid flex flex-nowrap justify-content-between">
					<div className="col-3 mr-3">
						<AppMenu onMenuItemClick={onMenuItemClick} />
					</div>
					<div className="col-9 pr-4">
						<AppTabView ref={menuRef} />
					</div>
				</div>
			</Card>
		</>
	);
}

export default App;
