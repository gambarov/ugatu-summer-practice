import React from 'react';
import { 
    PaginatorTemplate, 
    PaginatorRowsPerPageDropdownOptions, 
    PaginatorCurrentPageReportOptions, 
    PaginatorFirstPageLinkOptions, 
    PaginatorLastPageLinkOptions, 
    PaginatorJumpToPageInputOptions, 
    PaginatorNextPageLinkOptions, 
    PaginatorPrevPageLinkOptions, 
    PaginatorPageLinksOptions 
} from "primereact/paginator";
import { Dropdown } from "primereact/dropdown";

const Template: PaginatorTemplate = {
    layout: 'CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown',
    'RowsPerPageDropdown': (options: PaginatorRowsPerPageDropdownOptions) => {
        const dropdownOptions = [
            { label: 10, value: 10 },
            { label: 20, value: 20 },
            { label: 50, value: 50 },
            { label: 'Все', value: options.totalRecords },
        ];

        return <Dropdown value={options.value} options={dropdownOptions} onChange={options.onChange} />;
    },
    'CurrentPageReport': (options: PaginatorCurrentPageReportOptions) => {
        return (
            <span style={{ color: 'var(--text-color)', userSelect: 'none', width: '120px', textAlign: 'center' }}>
                {options.first} - {options.last} из {options.totalRecords}
            </span>
        )
    },
    'FirstPageLink': (options: PaginatorFirstPageLinkOptions) => {
        return options.element;
    },
    'LastPageLink': (options: PaginatorLastPageLinkOptions) => {
        return options.element;
    },
    'JumpToPageInput': (options: PaginatorJumpToPageInputOptions) => {
        return options.element;
    },
    'NextPageLink': (options: PaginatorNextPageLinkOptions) => {
        return options.element;
    },
    'PrevPageLink': (options: PaginatorPrevPageLinkOptions) => {
        return options.element;
    },
    'PageLinks': (options: PaginatorPageLinksOptions) => {
        return options.element;
    }
};

export default Template;