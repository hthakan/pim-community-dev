import {NotificationLevel} from '../src/DependenciesProvider.type';

const mockedDependencies = {
  router: {
    generate: jest.fn((route: string) => route),
    redirect: jest.fn((url: string) => url),
  },
  translate: jest.fn((key: string) => key),
  viewBuilder: {
    build: (viewName: string) => {
      return Promise.resolve({
        remove: jest.fn(),
        setElement: () => {
          return {
            render: jest.fn(() => viewName),
          };
        },
      });
    },
  },
  notify: jest.fn((level: NotificationLevel, message: string): string => {
    return `${level} ${message}`;
  }),
  user: {
    get: jest.fn((data: string) => {
      switch (data) {
        case 'catalogLocale':
          return 'en_US';
        case 'uiLocale':
          return 'en_US';
        default:
          return data;
      }
    }),
    set: jest.fn(),
  },
  security: {
    isGranted: jest.fn((_acl: string) => true),
  },
  mediator: {
    trigger: jest.fn((event: string) => event),
    on: jest.fn((event: string, _callback: () => void) => event),
    off: jest.fn((event: string, _callback: () => void) => event),
  },
};

export {mockedDependencies};
