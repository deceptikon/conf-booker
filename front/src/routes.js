import React from "react";
import { BrowserRouter as Router, Route, Switch, Redirect } from "react-router-dom";
import Registration from './components/Registration';
import ViewUsers from './components/ViewUsers';

const ProtectedRoute = ({ user, component: Component, ...rest }) => (
  <Route
    {...rest}
    render={props => {
      if (user.profileId) {
        return (<Component {...props} />);
      }
      return (<Redirect
        to={{
          pathname: "/login",
          state: { from: props.location }
        }}
      />
      )
    }
    }
  />
);
const user = {};

const AppRoutes = () => {
  return (
    <Router>
      <Switch>
        <ProtectedRoute user={user} path="/favourites/:action?" component={Registration} />
        <Route path="/" exact component={Registration} />
        <Route path="/see-members" exact component={ViewUsers} />
      </Switch>
    </Router>
  );
};

export default AppRoutes;
