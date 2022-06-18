import React, { forwardRef, useEffect, useImperativeHandle, useState } from 'react'
import {
	TabView,
	TabPanel,
	TabViewTabCloseParams,
	TabViewTabChangeParams,
	TabPanelHeaderTemplateType,
	TabPanelHeaderTemplateOptions
} from 'primereact/tabview';

// eslint-disable-next-line @typescript-eslint/no-empty-interface
interface Props { }

export interface AppTabPanel {
	id: number;
	header: React.ReactNode;
	content: React.ReactNode;
}

export interface AppTabViewHandle {
	addTabPanel: (tabPanel: AppTabPanel) => void;
	removeTabPanel: (id: number) => void;
}

const AppTabView: React.ForwardRefRenderFunction<AppTabViewHandle, Props> = (props, ref) => {
	const [tabPanels, setTabPanels] = useState<AppTabPanel[]>([]);
	const [activeIndex, setActiveIndex] = useState<number>(0);

	useImperativeHandle(ref, () => ({

		addTabPanel(tabPanel: AppTabPanel) {
			// Не более одной вкладки с одним идентификатором
			if (tabPanels.find(t => t.id === tabPanel.id)) {
				return;
			}
			setActiveIndex(tabPanels.length);
			setTabPanels([...tabPanels, { ...tabPanel }]);
		},

		removeTabPanel(id: number) {
			setTabPanels(tabPanels.filter(t => t.id !== id));
		}

	}));

	useEffect(() => {
		const maxIndex = tabPanels.length - 1;

		if (maxIndex > 0) {
			if (activeIndex > maxIndex) {
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

		return <a role="tab" onClick={options.onClick} className={options.className}
			aria-controls={options.ariaControls} aria-selected={options.selected} tabIndex={options.index}>
			<span className={options.titleClassName}>
				{tabPanel.header}
			</span>
			<i className="p-tabview-close pi pi-times"
				onClick={(e) => onTabClose({ originalEvent: e, index: options.index })} >
			</i>
		</a>;
	};

	if (tabPanels.length === 0) {
		return null;
	}

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

export default forwardRef(AppTabView);