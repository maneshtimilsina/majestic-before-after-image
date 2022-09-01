class App {
	constructor() {
		this.initTab();
	}

	initTab() {
		const mainWrapper = document.getElementById( 'wpc-wrapper' );
		const tabContents = document.getElementsByClassName( 'wpc-tab-content' );
		const tabLinks = document.querySelectorAll( '.nav-tab-wrapper a' );

		const tabContentsArray = [ ...tabContents ];
		const tabLinksArray = [ ...tabLinks ];

		// Initially hide tab content.
		tabContentsArray.forEach( ( elem ) => {
			elem.style.display = 'none';
		} );

		tabLinks.forEach( ( elem ) => {
			elem.classList.remove( 'nav-tab-active' );
		} );

		let activeTab = '';

		if ( 'undefined' !== typeof localStorage ) {
			activeTab = localStorage.getItem( mbaiAdmin.storage_key );
		}

		// Initial status for tab content.
		if ( null !== activeTab && document.getElementById( activeTab ) ) {
			const targetTab = document.getElementById( activeTab );
			if ( targetTab ) {
				targetTab.style.display = 'block';
			}
		} else {
			tabContents[ 0 ].style.display = 'block';
		}

		// Initial status for tab nav.
		if ( null !== activeTab && document.getElementById( activeTab ) ) {
			const targetNav = mainWrapper.querySelector( `.nav-tab-wrapper a[href="#${ activeTab }"]` );
			if ( targetNav ) {
				targetNav.classList.add( 'nav-tab-active' );
			}
		} else {
			tabLinks[ 0 ].classList.add( 'nav-tab-active' );
		}

		tabLinksArray.forEach( ( elem ) => {
			elem.addEventListener( 'click', ( e ) => {
				e.preventDefault();

				// Remove tab active class from all.
				tabLinksArray.forEach( ( element ) => {
					element.classList.remove( 'nav-tab-active' );
				} );

				// Add active class to current tab.
				elem.classList.add( 'nav-tab-active' );

				// Get target.
				const targetGroup = elem.getAttribute( 'href' );

				// Save active tab in local storage.
				if ( 'undefined' !== typeof localStorage ) {
					localStorage.setItem( mbaiAdmin.storage_key, targetGroup.replace( '#', '' ) );
				}

				tabContentsArray.forEach( ( element ) => {
					element.style.display = 'none';
				} );

				document.getElementById( targetGroup.replace( '#', '' ) ).style.display = 'block';
			} );
		} );
	}
}

document.addEventListener( 'DOMContentLoaded', function() {
	new App();
} );
