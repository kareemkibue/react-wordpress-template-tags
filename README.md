# :construction: React-Wordpress Template tags

A Collections of WordPress functions & template tags for use with React/WordPress hybrid applications.

<!-- 
## Table of Contnets

1. Purpose
2. Helper functions (PHP/WordPress)


## Purpose


## SEO Workarounds





## Helper Functions (PHP/WordPress)

### json_parse( )

**Args**
    decoded_string: _string_

**Return** 
    encoded_: _Object_
 


const componentMap = {
	header: (content) => <Header content={content} />,
	footer: (content) => <Footer content={content} />,
	home: (content) => <Home content={content} />,
	// about: (content) => <About content={content} />,
	contact: (content) => <Contact content={content} />,
};

const mapComponent = (targetComponent, content) => {
	const component = componentMap[targetComponent](content);
	/* if (targetComponent !== 'header' && targetComponent !== 'footer') {
		return (
		
		); */
	// } else return <Provider store={store}>{component}</Provider>;
};

const domMountPoints = document.querySelectorAll('[data-component]');

for (let i = 0; i < domMountPoints.length; i++) {
	const targetComponent = domMountPoints[i].getAttribute('data-component');
	const content = domMountPoints[i].getAttribute('data-content');
	const parsedContent = content !== '' && content !== null && content !== undefined ? JSON.parse(content) : {};
	domMountPoints[i].removeAttribute('data-component');
	domMountPoints[i].removeAttribute('data-content');

	console.log(targetComponent, 'props \n==================');
	console.log(parsedContent);

	if (componentMap[targetComponent] !== null) {
		ReactDOM.render(mapComponent(targetComponent, parsedContent), domMountPoints[i]);
	}
}
 -->