import React, { Component } from 'react';
import ApolloClient from 'apollo-boost';
import { ApolloProvider } from 'react-apollo';
import Alert from 'react-s-alert';
import AppRoutes from './routes';

import './App.css';
import 'react-s-alert/dist/s-alert-default.css';
import 'react-s-alert/dist/s-alert-css-effects/slide.css';

const style = {
  margin: '0 auto',
  minHeight: '600px',
  padding: '30px 10px',
};

const defaultOptions = {
  fetchOptions: {
    mode: 'no-cors',
  },
  watchQuery: {
    fetchPolicy: 'cache-and-network',
    errorPolicy: 'ignore',
  },
  query: {
    fetchPolicy: 'network-only',
    errorPolicy: 'all',
  },
  mutate: {
    errorPolicy: 'all'
  }
};

const client = new ApolloClient({
  // uri: "http://localhost:8000/graphql",
  uri: "http://arkr.kg/api/",
});

client.options = defaultOptions;

class App extends Component {
  render() {
    return (
      <ApolloProvider client={client}>
        <div className="App" style={style}>
          <AppRoutes />
          <Alert stack={{limit: 3}} timeout={5000} />
        </div>
      </ApolloProvider>
    );
  }
}

export default App;
