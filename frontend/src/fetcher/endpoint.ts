const backendApi = process.env.BACKEND_API;
if (!backendApi) {
  throw new Error("You must specify a BACKEND_API (StdBackendServer).");
}

export default function api(endpoint: string): URL {
  return new URL(endpoint, process.env.BACKEND_API);
}
