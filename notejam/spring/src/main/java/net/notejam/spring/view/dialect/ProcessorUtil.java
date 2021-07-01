package net.notejam.spring.view.dialect;

import org.thymeleaf.Arguments;
import org.thymeleaf.Configuration;
import org.thymeleaf.dom.Element;
import org.thymeleaf.standard.expression.IStandardExpression;
import org.thymeleaf.standard.expression.IStandardExpressionParser;
import org.thymeleaf.standard.expression.StandardExpressions;

/**
 * A utility for attribute processors.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
final class ProcessorUtil {

    /**
     * No public constructor for this utility class.
     */
    private ProcessorUtil() {
    }

    /**
     * Returns the value from the attribute expression.
     *
     * @param arguments
     *            The arguments.
     * @param element
     *            The element.
     * @param attributeName
     *            The attribute name
     * @return The text.
     */
    @SuppressWarnings("unchecked")
    static <T> T getValue(final Arguments arguments, final Element element, final String attributeName) {
        Configuration configuration = arguments.getConfiguration();
        String attributeValue = element.getAttributeValue(attributeName);
        IStandardExpressionParser parser = StandardExpressions.getExpressionParser(configuration);
        IStandardExpression expression = parser.parseExpression(configuration, arguments, attributeValue);
        return (T) expression.execute(configuration, arguments);
    }

}
