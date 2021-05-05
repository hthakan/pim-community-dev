import {getLabel, LocaleCode} from '@akeneo-pim-community/shared';
import {LabelCollection} from 'akeneomeasure/model/label-collection';
import {Operation} from 'akeneomeasure/model/operation';

type UnitCode = string;

type Unit = {
  code: UnitCode;
  labels: LabelCollection;
  symbol: string;
  convert_from_standard: Operation[];
};

const getUnitLabel = (unit: Unit, locale: LocaleCode) => getLabel(unit.labels, locale, unit.code);

export {getUnitLabel};
export type {Unit, UnitCode};
