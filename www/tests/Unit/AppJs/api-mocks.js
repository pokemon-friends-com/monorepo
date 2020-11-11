const { assign } = require('lodash');
const axios = require('axios');
const sinon = require('sinon');

const userData = {
  identifier: '123455abcdef',
  full_name: 'Antoine Benevaut',
  civility_name: 'Monsieur Benevaut Antoine',
  civility: {
    key: 'mister',
    trans: 'Monsieur',
  },
  first_name: 'Antoine',
  last_name: 'Benevaut',
  email: 'antoine@benevaut.fr',
  role: {
    key: 'administrator',
    trans: 'Administrateur',
  },
  family_situation: {
    key: 'single',
    trans: 'profiles.family_situation.single',
  },
  maiden_name: null,
  birth_date: '12Saturday2019bamSaturday.31am31Europe/Paris_f2019Sat, 31 Aug 2019 00:00:00 +020008am31',
  locale: {
    language: 'fr',
    timezone: 'Europe/Paris',
  },
  is_sidebar_pined: true,
};

module.exports = {
  userData,
  /**
   *
   */
  beforeEach: () => {
    sinon.restore();
  },
  /**
   * @param dataOverload
   */
  getUser: (dataOverload) => {
    const data = assign({}, userData, dataOverload);

    return sinon
      .stub(axios, 'get')
      .withArgs('/api/v1/users/user')
      .resolves(Promise.resolve({ status: 200, data }));
  },
  /**
   * @param dataOverload
   */
  putUserProfile: (dataOverload) => {
    const data = assign({}, userData, dataOverload);

    return sinon
      .stub(axios, 'put')
      .withArgs(`/api/v1/users/profiles/${data.identifier}`, dataOverload)
      .resolves(Promise.resolve({ status: 200, data }));
  },
};
