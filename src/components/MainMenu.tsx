import React, { useMemo } from 'react';
import { Menu } from 'primereact/menu';

interface Props {
	onMenuItemClick: (label: string) => void;
}

const MainMenu: React.FC<Props> = ({onMenuItemClick}) => {
	const items = useMemo(() => [
		{
			label: 'Модули',
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
					icon: 'pi pi-folder',
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
				}
			]
		}
	], []);

	return (
		<Menu model={items} className='min-w-full'/>
	)
}

export default MainMenu