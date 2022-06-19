import React from 'react';
import { Menubar } from 'primereact/menubar';

const AppMenubar: React.FC = () => {
	const start = (
		<h2>
			МАГЛ
		</h2>
	);
	return (
		<div>
			<Menubar start={start} className='mb-3' />
		</div>
	);
};

export default AppMenubar;