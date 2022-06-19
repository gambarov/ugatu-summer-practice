import React, { useMemo } from 'react';
import { Menu } from 'primereact/menu';

interface Props {
	onMenuItemClick: (label: string) => void;
}

const AppMenu: React.FC<Props> = ({onMenuItemClick}) => {
	const items = useMemo(() => [
		{
			label: 'Разделы',
			items: [
				{
					label: 'МТО',
					icon: 'pi pi-desktop',
					command: () => {
						onMenuItemClick('МТО');
					}
				},
				{
					label: 'Комплекты',
					icon: 'pi pi-box',
					command: () => {
						onMenuItemClick('Комплекты');
					}
				},
				{
					label: 'Аудитории',
					icon: 'pi pi-user',
					command: () => {
						onMenuItemClick('Аудитории');
					}
				},
				{
					label: 'Размещение',
					icon: 'pi pi-history',
					command: () => {
						onMenuItemClick('Размещение');
					}
				}
			]
		}
	], []);

	return (
		<Menu model={items} className='min-w-full'/>
	)
}

export default AppMenu