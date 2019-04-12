// Simulate loading data from server

export default function loadStuff() {
  return new Promise(
    function waitAndResolve(resolve, reject) {
      window.setTimeout(
        function delayedResolution() {
          resolve({ data: { query: "mozilla" }});
        },
        1000
      );
    }
  );
}
