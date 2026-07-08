( function () {
	'use strict';

	const getVisibleCount = ( row, track ) => {
		const explicit = parseInt( row.dataset.visible || '', 10 );
		if ( explicit > 0 ) {
			return explicit;
		}

		if ( track.classList.contains( 'ardeso-portfolio-strip' ) ) {
			return window.matchMedia( '(max-width: 700px)' ).matches ? 1 : 3;
		}

		if ( track.classList.contains( 'ardeso-values-grid' ) ) {
			return window.matchMedia( '(max-width: 700px)' ).matches ? 1 : 3;
		}

		if ( track.classList.contains( 'ardeso-logo-grid' ) ) {
			return window.matchMedia( '(max-width: 700px)' ).matches ? 1 : 3;
		}

		return 1;
	};

	const makeButton = ( element, label ) => {
		element.setAttribute( 'role', 'button' );
		element.setAttribute( 'tabindex', '0' );
		element.setAttribute( 'aria-label', label );
		element.addEventListener( 'keydown', ( event ) => {
			if ( event.key === 'Enter' || event.key === ' ' ) {
				event.preventDefault();
				element.click();
			}
		} );
	};

	const initSlider = ( row, index ) => {
		const children = Array.from( row.children );
		const prev = children[0];
		const track = children[1];
		const next = children[2];

		if ( ! prev || ! track || ! next ) {
			return;
		}

		const slides = Array.from( track.children );
		if ( slides.length < 2 ) {
			row.classList.add( 'ardeso-slider-static' );
			return;
		}

		let current = 0;
		let visible = getVisibleCount( row, track );
		const dots = row.parentElement ? row.parentElement.querySelector( '.ardeso-dots' ) : null;

		row.classList.add( 'is-ready' );
		row.dataset.ardesoSlider = 'true';
		track.classList.add( 'ardeso-slider-track' );
		slides.forEach( ( slide ) => slide.classList.add( 'ardeso-slide' ) );
		makeButton( prev, 'Anterior' );
		makeButton( next, 'Siguiente' );

		const viewport = document.createElement( 'div' );
		viewport.className = 'ardeso-slider-viewport';
		row.insertBefore( viewport, track );
		viewport.appendChild( track );

		const renderDots = () => {
			if ( ! dots ) {
				return;
			}

			visible = Math.min( getVisibleCount( row, track ), slides.length );
			const pages = Math.max( 1, slides.length - visible + 1 );
			dots.innerHTML = '';
			dots.setAttribute( 'aria-label', 'Paginación del carrusel' );

			for ( let i = 0; i < pages; i += 1 ) {
				const dot = document.createElement( 'button' );
				dot.type = 'button';
				dot.className = 'ardeso-dot';
				dot.setAttribute( 'aria-label', `Ir al grupo ${ i + 1 }` );
				dot.addEventListener( 'click', () => {
					current = i;
					update();
				} );
				dots.appendChild( dot );
			}
		};

		const update = () => {
			visible = Math.min( getVisibleCount( row, track ), slides.length );
			const max = Math.max( 0, slides.length - visible );
			current = Math.max( 0, Math.min( current, max ) );
			const gap = parseFloat( window.getComputedStyle( track ).columnGap || '0' ) || 0;
			const totalGap = gap * Math.max( 0, visible - 1 );
			const width = ( viewport.clientWidth - totalGap ) / visible;
			const step = width + gap;

			slides.forEach( ( slide ) => {
				slide.style.flex = `0 0 ${ width }px`;
			} );

			track.style.transform = `translate3d(-${ current * step }px, 0, 0)`;
			prev.setAttribute( 'aria-disabled', current === 0 ? 'true' : 'false' );
			next.setAttribute( 'aria-disabled', current === max ? 'true' : 'false' );

			if ( dots ) {
				const dotButtons = dots.querySelectorAll( '.ardeso-dot' );
				dotButtons.forEach( ( dot, dotIndex ) => {
					dot.classList.toggle( 'is-active', dotIndex === current );
					dot.setAttribute( 'aria-current', dotIndex === current ? 'true' : 'false' );
				} );
			}
		};

		prev.addEventListener( 'click', () => {
			current -= 1;
			update();
		} );

		next.addEventListener( 'click', () => {
			current += 1;
			update();
		} );

		row.setAttribute( 'aria-roledescription', 'carrusel' );
		row.setAttribute( 'aria-label', `Carrusel ${ index + 1 }` );
		renderDots();
		update();
		window.addEventListener( 'resize', () => {
			renderDots();
			update();
		} );
	};

	const initServiceAccordion = ( container ) => {
		const details = Array.from( container.querySelectorAll( '.ardeso-service-detail' ) );

		if ( details.length < 2 ) {
			return;
		}

		const setStableHeight = () => {
			const currentOpenIndex = Math.max( 0, details.findIndex( ( detail ) => detail.open ) );
			let maxHeight = 0;

			details.forEach( ( detail, detailIndex ) => {
				details.forEach( ( item, itemIndex ) => {
					item.open = itemIndex === detailIndex;
				} );
				maxHeight = Math.max( maxHeight, container.scrollHeight );
			} );

			details.forEach( ( item, itemIndex ) => {
				item.open = itemIndex === currentOpenIndex;
			} );

			container.style.minHeight = `${ Math.ceil( maxHeight ) }px`;
		};

		details.forEach( ( detail, detailIndex ) => {
			const summary = detail.querySelector( 'summary' );

			if ( ! summary ) {
				return;
			}

			summary.addEventListener( 'click', ( event ) => {
				event.preventDefault();

				details.forEach( ( item, itemIndex ) => {
					item.open = itemIndex === detailIndex;
				} );
			} );
		} );

		if ( ! details.some( ( detail ) => detail.open ) ) {
			details[0].open = true;
		}

		setStableHeight();
		window.addEventListener( 'resize', setStableHeight );
	};

	document.addEventListener( 'DOMContentLoaded', () => {
		document.querySelectorAll( '.ardeso-slider-row' ).forEach( initSlider );
		document.querySelectorAll( '.ardeso-services-split .wp-block-media-text__content' ).forEach( initServiceAccordion );
	} );
}() );
