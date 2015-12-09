package net.notejam.spring.helper.converter;

import java.time.Period;

import org.springframework.core.convert.converter.Converter;

/**
 * Converts an ISO-8601 period into a Period.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
public final class StringToPeriodConverter implements Converter<String, Period> {

    @Override
    public Period convert(final String period) {
        return Period.parse(period);
    }

}
