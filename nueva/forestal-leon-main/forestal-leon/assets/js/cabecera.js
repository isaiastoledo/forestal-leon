/**
 * Cabecera: estado al hacer scroll, mega menú de Productos y menú de móvil.
 *
 * Sin JavaScript el sitio sigue siendo navegable: el panel de Productos queda
 * cerrado, pero «Productos» es un enlace normal que lleva al catálogo, y desde
 * ahí se llega a las tres familias y a las nueve fichas.
 */
( function () {
	'use strict';

	var cabecera = document.querySelector( '.fl-cabecera' );

	if ( ! cabecera ) {
		return;
	}

	document.documentElement.classList.add( 'fl-js' );

	/* ------------------------------------------------------------------ */
	/* 1. Fondo blanco al hacer scroll (solo hace algo en la portada)      */
	/* ------------------------------------------------------------------ */

	var UMBRAL = 24;
	var solida = null;
	var pendiente = false;

	function aplicarScroll() {
		pendiente = false;

		var debe = window.scrollY > UMBRAL;

		if ( debe === solida ) {
			return;
		}

		solida = debe;
		cabecera.classList.toggle( 'fl-cabecera--solida', debe );
	}

	function alHacerScroll() {
		if ( ! pendiente ) {
			pendiente = true;
			window.requestAnimationFrame( aplicarScroll );
		}
	}

	aplicarScroll();
	window.addEventListener( 'scroll', alHacerScroll, { passive: true } );
	window.addEventListener( 'resize', alHacerScroll, { passive: true } );
	window.addEventListener( 'pageshow', aplicarScroll );

	/* ------------------------------------------------------------------ */
	/* 2. Mega menús (Construcción en madera y Productos)                 */
	/* ------------------------------------------------------------------ */

	var megas = [];

	Array.prototype.forEach.call(
		cabecera.querySelectorAll( '.fl-nav__desplegar' ),
		function ( disparador ) {
			var panel = document.getElementById( disparador.getAttribute( 'aria-controls' ) );
			var contenedor = disparador.closest( '.fl-nav__item--mega' );

			if ( panel && contenedor ) {
				megas.push( { disparador: disparador, panel: panel, contenedor: contenedor } );
			}
		}
	);

	function abrirPanel( mega, abierto ) {
		if ( ! mega ) {
			return;
		}

		// Solo uno abierto a la vez.
		if ( abierto ) {
			megas.forEach( function ( otro ) {
				if ( otro !== mega ) {
					otro.disparador.setAttribute( 'aria-expanded', 'false' );
					otro.panel.hidden = true;
				}
			} );
		}

		mega.disparador.setAttribute( 'aria-expanded', abierto ? 'true' : 'false' );
		mega.panel.hidden = ! abierto;
		cabecera.classList.toggle( 'tiene-panel-abierto', hayAlgunoAbierto() );
	}

	function hayAlgunoAbierto() {
		return megas.some( function ( m ) {
			return m.disparador.getAttribute( 'aria-expanded' ) === 'true';
		} );
	}

	function cerrarTodos() {
		megas.forEach( function ( m ) {
			m.disparador.setAttribute( 'aria-expanded', 'false' );
			m.panel.hidden = true;
		} );
		cabecera.classList.remove( 'tiene-panel-abierto' );
	}

	var conRaton = window.matchMedia( '(hover: hover) and (min-width: 1024px)' );

	megas.forEach( function ( mega ) {
		var cerrarConRetraso;

		mega.disparador.addEventListener( 'click', function ( e ) {
			e.preventDefault();
			abrirPanel( mega, mega.disparador.getAttribute( 'aria-expanded' ) !== 'true' );
		} );

		mega.contenedor.addEventListener( 'mouseenter', function () {
			if ( conRaton.matches ) {
				window.clearTimeout( cerrarConRetraso );
				abrirPanel( mega, true );
			}
		} );

		mega.contenedor.addEventListener( 'mouseleave', function () {
			if ( conRaton.matches ) {
				// Margen para cruzar el hueco con el ratón sin que se cierre.
				cerrarConRetraso = window.setTimeout( function () {
					abrirPanel( mega, false );
				}, 180 );
			}
		} );
	} );

	// Al salir de la cabecera con el tabulador, se cierra lo que hubiera abierto.
	cabecera.addEventListener( 'focusout', function ( e ) {
		if ( conRaton.matches && ! cabecera.contains( e.relatedTarget ) ) {
			cerrarTodos();
		}
	} );

	/* ------------------------------------------------------------------ */
	/* 3. Menú de móvil                                                   */
	/* ------------------------------------------------------------------ */

	var hamburguesa = cabecera.querySelector( '.fl-nav__hamburguesa' );
	var lista = hamburguesa && document.getElementById(
		hamburguesa.getAttribute( 'aria-controls' )
	);

	function abrirMenu( abierto ) {
		if ( ! hamburguesa || ! lista ) {
			return;
		}

		hamburguesa.setAttribute( 'aria-expanded', abierto ? 'true' : 'false' );
		lista.classList.toggle( 'esta-abierto', abierto );
		cabecera.classList.toggle( 'tiene-panel-abierto', abierto );

		if ( ! abierto ) {
			cerrarTodos();
		}
	}

	function menuAbierto() {
		return hamburguesa && hamburguesa.getAttribute( 'aria-expanded' ) === 'true';
	}

	if ( hamburguesa && lista ) {
		hamburguesa.addEventListener( 'click', function () {
			abrirMenu( ! menuAbierto() );
		} );
	}

	/* ------------------------------------------------------------------ */
	/* 4. Cerrar: Escape y clic fuera                                     */
	/* ------------------------------------------------------------------ */

	document.addEventListener( 'keydown', function ( e ) {
		if ( e.key !== 'Escape' ) {
			return;
		}

		if ( hayAlgunoAbierto() ) {
			var abierto = megas.filter( function ( m ) {
				return m.disparador.getAttribute( 'aria-expanded' ) === 'true';
			} )[ 0 ];
			cerrarTodos();
			if ( abierto ) {
				abierto.disparador.focus();
			}
		} else if ( menuAbierto() ) {
			abrirMenu( false );
			hamburguesa.focus();
		}
	} );

	document.addEventListener( 'click', function ( e ) {
		if ( cabecera.contains( e.target ) ) {
			return;
		}

		if ( hayAlgunoAbierto() ) {
			cerrarTodos();
		}

		if ( menuAbierto() ) {
			abrirMenu( false );
		}
	} );
}() );
