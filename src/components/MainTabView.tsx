import React, { forwardRef, useEffect, useImperativeHandle, useState } from 'react'
import { TabView, TabPanel, TabViewTabCloseParams, TabViewTabChangeParams, TabPanelHeaderTemplateType, TabPanelHeaderTemplateOptions } from 'primereact/tabview';
import { Button } from 'primereact/button';

// eslint-disable-next-line @typescript-eslint/no-empty-interface
interface Props { }

export interface CustomTabPanel {
	id: number;
	header: React.ReactNode;
	content: React.ReactNode;
}

export interface MainTabViewHandle {
	addTabPanel: (tabPanel: CustomTabPanel) => void;
	removeTabPanel: (id: number) => void;
}

const MainTabView: React.ForwardRefRenderFunction<MainTabViewHandle, Props> = (props, ref) => {
	const [tabPanels, setTabPanels] = useState<CustomTabPanel[]>([]);
	const [activeIndex, setActiveIndex] = useState<number>(0);

	useImperativeHandle(ref, () => ({

		addTabPanel(tabPanel: CustomTabPanel) {
			// Не более одной вкладки с одним идентификатором
			if (tabPanels.find(t => t.id === tabPanel.id)) {
				return;
			}
			setTabPanels([...tabPanels, { ...tabPanel }]);
		},

		removeTabPanel(id: number) {
			setTabPanels(tabPanels.filter(t => t.id !== id));
		}

	}));

	useEffect(() => {
		const maxIndex = tabPanels.length - 1;

		if (maxIndex > 0) {
			if (activeIndex >= maxIndex) {
				setActiveIndex(maxIndex);
			}
		} else {
			setActiveIndex(0);
		}
	}, [tabPanels]);

	const onTabClose = (e: TabViewTabCloseParams) => {
		setTabPanels(tabPanels.filter((t, i) => i !== e.index));
	}

	const onTabChange = (e: TabViewTabChangeParams) => {
		setActiveIndex(e.index);
	}

	const template: TabPanelHeaderTemplateType = (options: TabPanelHeaderTemplateOptions) => {
		const tabPanel = tabPanels[options.index];

		return <div className={options.className}>
			<Button className="p-button-text" onClick={options.onClick}>
				<span className="p-tabview-tab-text">{tabPanel.header}</span>
			</Button>
			<Button icon="pi pi-times" className="p-button-rounded p-button-text"
				onClick={(e) => onTabClose({ originalEvent: e, index: options.index })} />
		</div>;
	};

	return (
		<TabView onTabClose={onTabClose} onTabChange={onTabChange} activeIndex={activeIndex}>
			{tabPanels.map((tabPanel) => {
				return (
					<TabPanel header={tabPanel.header} key={tabPanel.id} headerTemplate={template}>
						{tabPanel.content}
					</TabPanel>
				)
			})}
		</TabView>
	)
}

export default forwardRef(MainTabView);