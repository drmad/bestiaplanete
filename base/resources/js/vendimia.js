/**
 * Javascript helpers
 */
 class V {
    /**
     * Returns an element from its ID attribute
     */
    static id(id) {
        return document.getElementById(id)
    }

    /**
     * Returns an element using a query selector
     */
    static e(query) {
        return document.querySelector(query)
    }

    /**
     * Returns all elements matching a query selector
     */
    static es(query) {
        return document.querySelectorAll(query)
    }

    /**
     * Creates a new tag
     */
    static c(tag, attributes = {}, innerHTML = '')
    {
        let element = document.createElement(tag)
        for (const [key, value] of Object.entries(attributes)) {
            element.setAttribute(key, value)
        }
        if (innerHTML !== null) {
            element.innerHTML = innerHTML
        }

        return element
    }

    /**
     * Creates a new tag
     */
    static post(url, args = {}) {
        let form = V.c('form', {action: url, method: 'post'})
        for (const [key, value] of Object.entries(args)) {
            form.append(V.c('input', {
                type: 'hidden',
                name: key,
                value: value,
            }))
        }
        document.body.append(form)
        form.submit()
    }
}
