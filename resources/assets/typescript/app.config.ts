class AppConfig {
	private _apiEndpoint: string
	private _templateEndpoint: string
	constructor() {
		this._apiEndpoint = 'api/v1/';
		this._templateEndpoint = 'template/';
	}

	api(uri:string) {
		return this._apiEndpoint + uri;
	}

	template(uri:string) {
		return this._templateEndpoint + uri;
	}
}

export const Config = new AppConfig();