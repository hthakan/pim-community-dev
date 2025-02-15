import React, {Component} from 'react';
import {PageContent, PageHeader, RuntimeError} from '../../common/components';
import {useRoute} from '../../shared/router';
import {Translate} from '../../shared/translate';
import {Breadcrumb} from 'akeneo-design-system';
import {UserButtons} from '../../shared/user';

const SettingsBreadcrumb = () => {
    const systemHref = `#${useRoute('oro_config_configuration_system')}`;

    return (
        <Breadcrumb>
            <Breadcrumb.Step href={systemHref}>
                <Translate id='pim_menu.tab.system' />
            </Breadcrumb.Step>
            <Breadcrumb.Step>
                <Translate id='pim_menu.item.connection_settings' />
            </Breadcrumb.Step>
        </Breadcrumb>
    );
};

export class SettingsErrorBoundary extends Component<unknown, {hasError: boolean}> {
    constructor(props: unknown) {
        super(props);
        this.state = {hasError: false};
    }

    static getDerivedStateFromError() {
        return {hasError: true};
    }

    render() {
        if (this.state.hasError) {
            return (
                <>
                    <PageHeader breadcrumb={<SettingsBreadcrumb />} userButtons={<UserButtons />} />

                    <PageContent>
                        <RuntimeError />
                    </PageContent>
                </>
            );
        }

        return this.props.children;
    }
}
