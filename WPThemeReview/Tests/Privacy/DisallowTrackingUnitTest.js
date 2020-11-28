import ReactGA from 'react-ga';
...
ReactGA.initialize('UA-000000000-0'); // Error.

// This function reports an event to Google Analytics servers.
ga('send', 'event', [eventCategory], [eventAction], [eventLabel], [eventValue], [fieldsObject]); // Error.