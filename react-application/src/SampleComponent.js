import React, { Component } from 'react';

import { secureToken, tenantId, intentId, intentListSize } from './saasler-setup';
import loadStuff from './load-stuff';

// Sample component that shows a Saasler button

class SampleComponent extends Component {
  state = { saaslerElements: null }

  onStuffLoaded = ({data }) => {
    this.setState(
      { saaslerElements: JSON.stringify(data) },
      function initSaasler() {
        window.saasler.init(tenantId, secureToken, intentListSize);
      }
    );
  }

  componentDidMount() {
    loadStuff().then(this.onStuffLoaded);
  }

  render() {
    const { saaslerElements } = this.state;

    return (
      <div>
        { (saaslerElements === null) ? (
          <p>Loading...</p>
        ) : (
          <div>
            <div id="saasler-integrations" className="panel-body js-saasler-intents" />
            <button
              className="js-saasler-popup"
              data-sid={intentId}
              data-saaslerElements={saaslerElements}
              href="#saasler-popup"
            >
              Basecamp
            </button>
          </div>
        ) }
      </div>
    );
  }
}

SampleComponent.displayName = 'SampleComponent';

export default SampleComponent;
