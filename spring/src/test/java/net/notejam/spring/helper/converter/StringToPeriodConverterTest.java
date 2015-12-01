package net.notejam.spring.helper.converter;

import static org.junit.Assert.assertEquals;

import java.time.Period;

import org.junit.Test;

/**
 * A test for StringToPeriodConverter
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
public class StringToPeriodConverterTest {

    @Test
    public void testConvert() {
        StringToPeriodConverter converter = new StringToPeriodConverter();

        assertEquals(Period.ofDays(1), converter.convert("P1D"));
    }

}
