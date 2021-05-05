import React from 'react';
import ReactController from '../react/react-controller';
import {MeasurementApp} from '@akeneo-pim-community/measurement';
import {measurementsDependencies} from '../dependencies';
import {ConfigContext} from '@akeneo-pim-community/measurement/lib/context/config-context';
import {UnsavedChangesContext} from '@akeneo-pim-community/measurement/lib/context/unsaved-changes-context';
import {DependenciesProvider} from '@akeneo-pim-community/legacy-bridge';
import {ThemeProvider} from 'styled-components';
import {pimTheme} from 'akeneo-design-system';

const mediator = require('oro/mediator');
const __ = require('oro/translator');

class SettingsController extends ReactController {
  reactElementToMount() {
    return (
      <ThemeProvider theme={pimTheme}>
        <DependenciesProvider>
          <ConfigContext.Provider value={measurementsDependencies.config}>
            <UnsavedChangesContext.Provider value={measurementsDependencies.unsavedChanges}>
              <MeasurementApp/>
            </UnsavedChangesContext.Provider>
          </ConfigContext.Provider>
        </DependenciesProvider>
      </ThemeProvider>
    );
  }

  routeGuardToUnmount() {
    return /^akeneo_measurements_settings_/;
  }

  renderRoute() {
    mediator.trigger('pim_menu:highlight:tab', {extension: 'pim-menu-settings'});
    mediator.trigger('pim_menu:highlight:item', {extension: 'pim-menu-measurements-settings'});

    return super.renderRoute();
  }

  canLeave() {
    return !measurementsDependencies.unsavedChanges.hasUnsavedChanges || confirm(__('pim_ui.flash.unsaved_changes'));
  }
}

export = SettingsController;
