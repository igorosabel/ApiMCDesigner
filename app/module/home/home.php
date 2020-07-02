<?php declare(strict_types=1);
class home extends OModule {
	/**
	 * Página temporal, sitio cerrado
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 *
	 * @return void
	 */
	function closed(ORequest $req): void {
		OUrl::goToUrl('https://mcdesigner.osumi.es');
	}

	/**
	 * Home pública
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 *
	 * @return void
	 */
	function index(ORequest $req): void {
		OUrl::goToUrl('https://mcdesigner.osumi.es');
	}

	/**
	 * Página de error 404
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 *
	 * @return void
	 */
	function notFound(ORequest $req): void {
		OUrl::goToUrl('https://mcdesigner.osumi.es');
	}
}