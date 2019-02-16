import React, { Component } from 'react';
import ApolloClient from 'apollo-boost';
import { ApolloProvider } from 'react-apollo';

import Registration from './components/Registration';
import './App.css';

const style = {
  margin: '0 auto',
  maxWidth: '800px',
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
  uri: "http://localhost:8000/graphql",
});

client.options = defaultOptions;

class App extends Component {
  render() {
    return (
      <ApolloProvider client={client}>
        <div className="App" style={style}>
          <Registration />
        </div>
      </ApolloProvider>
    );
  }
}

export default App;
