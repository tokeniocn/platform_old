
const G = {
  baseUrl: window.location ? window.location.origin : '',
  ...(window.G || {})
};

export default G;
